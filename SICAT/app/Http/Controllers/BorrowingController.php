<?php

namespace App\Http\Controllers;

use App\BorrowedItem;
use App\Borrowing;
use App\Http\Requests\StoreBorrowingRequest;
use App\Item;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class BorrowingController extends Controller
{
    private $borrowing;

    public function __construct(Borrowing $borrowing)
    {
        $this->borrowing = $borrowing;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|Response|View
     * @throws Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $borrowings = DB::table('borrowings')
                ->select(['borrowings.id', 'borrowings.requester', 'borrowings.acquisition_date', 'statuses.name as status'])
                ->join('statuses', 'borrowings.status_id', '=', 'statuses.id')
                ->get();

            foreach ($borrowings as $borrowing) {
                $borrowing->items = DB::table('borrowed_items')
                    ->select('items.name')
                    ->join('items', 'borrowed_items.item_id', '=', 'items.id')
                    ->join('statuses', 'borrowed_items.status_id', '=', 'statuses.id')
                    ->where('borrowed_items.borrowing_id', '=', $borrowing->id)
                    ->get();
            };

            return Datatables::of($borrowings)
                ->addColumn('action', function ($data) {
                    $result = '<div class="btn-group btn-group-sm" role="group" aria-label="Exemplo básico">';
                    if (Gate::allows('rolesUser', 'borrowing_view')) {
                        $result .= '<button type="button" id="' . $data->id . '" class="btn btn-primary" data-toggle="modal" data-target="#modalView" data-whatever="' . $data->id . '""><i class="fas fa-fw fa-eye mr-1"></i>Visualizar</button>';
                    }
                    if (Gate::allows('rolesUser', 'borrowing_edit') && $data->status != 'Finalizado') {
                        $result .= '<button type="button" id="' . $data->id . '" class="btn btn-secondary" data-toggle="modal" data-target="#modalEdit" data-whatever="' . $data->id . '""><i class="fas fa-fw fa-edit mr-1"></i>Editar</button>';
                    }

                    $result .= '</div>';
                    return $result;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('dashboard.borrowing.list-borrowing');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        $types = DB::table('types')->select('id', 'name')->get();

        $status = DB::table('statuses')->select('id', 'name')
            ->where('name', '=', 'Emprestado')
            ->first();

        return view('dashboard.borrowing.create-borrowing', ['types' => $types, 'status' => $status]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBorrowingRequest $request
     * @return JsonResponse
     */
    public function store(StoreBorrowingRequest $request)
    {

        try {

            $data = $request->all();

            $items[] = null;

            for ($i = 0; $i < count($data['items']); $i++) {
                $items[$i]['item_id'] = $data['items'][$i]['item_id'];
                $items[$i]['amount'] = $data['items'][$i]['amount'];
                $items[$i]['lender_id'] = Auth::user()->id;
                $items[$i]['status_id'] = $data['status_id'];
            }

            DB::transaction(function () use ($data, $items) {
                $borrowing = Borrowing::create($data);
                foreach ($items as $item) {
                    $borrowing->borrowed_item()->create($item);
                    Item::where('id', '=', $item['item_id'])
                        ->decrement('amount', $item['amount']);
                    DB::select('CALL update_availability(?)', [$item['item_id']]);
                }
            });

            return response()->json(["message" => "Cadastrado com sucesso"], 201);
        } catch (Exception $e) {
            if (config('app.debug')) {
                return response()->json(["message" => $e->getMessage()], 400);
            }

            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Borrowing $borrowing
     * @return Collection
     */
    public function show($borrowing)
    {
        $borrowings = DB::table('borrowings')
            ->select('borrowings.id', 'borrowings.requester', 'borrowings.phone_requester', 'borrowings.email_requester', 'borrowings.office_requester', 'borrowings.acquisition_date', 'statuses.name as status')
            ->join('statuses', 'borrowings.status_id', '=', 'statuses.id')
            ->where('borrowings.id', '=', $borrowing)
            ->get();

        $borrowings[0]->items = DB::table('borrowed_items')
            ->select('borrowed_items.id', 'items.name', 'borrowed_items.amount',
                DB::raw('(borrowed_items.amount - borrowed_items.amount_returned) as remaining_amount'),
                DB::raw('(SELECT users.name FROM users WHERE borrowed_items.borrowing_id = ' . $borrowings[0]->id . ' and borrowed_items.lender_id = users.id) as lender'),
                DB::raw('(SELECT users.name FROM users WHERE borrowed_items.borrowing_id = ' . $borrowings[0]->id . ' and borrowed_items.receiver_id = users.id) as receiver'),
                'borrowed_items.return_date',
                'statuses.name as status')
            ->join('items', 'borrowed_items.item_id', '=', 'items.id')
            ->join('statuses', 'borrowed_items.status_id', '=', 'statuses.id')
            ->where('borrowed_items.borrowing_id', '=', $borrowings[0]->id)
            ->get();

        $borrowings[0]->acquisition_date = \Carbon\Carbon::parse($borrowings[0]->acquisition_date)->format('d/m/Y');

        foreach ($borrowings[0]->items as $items) {
            if ($items->return_date !== null) {
                $items->return_date = \Carbon\Carbon::parse($items->return_date)->format('d/m/Y');
            }
        }

        return $borrowings;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $borrowing
     * @return JsonResponse
     */
    public function update(Request $request, $borrowing)
    {
        try {

            $data = $request->all();
            $data['receiver_id'] = Auth::user()->id;

            DB::transaction(function () use ($data, $borrowing) {
                foreach ($data['items'] as $item) {
                    DB::table('borrowed_items')
                        ->where('borrowing_id', '=', $borrowing)
                        ->where('id', '=', $item['id'])
                        ->increment('amount_returned', $item['amount'], ['receiver_id' => $data['receiver_id'], 'return_date' => $item['return_date']]);

                    $amounts = DB::table('borrowed_items')
                        ->select('amount', 'amount_returned')
                        ->where('borrowing_id', '=', $borrowing)
                        ->where('id', '=', $item['id'])
                        ->first();

                    if ($amounts->amount === $amounts->amount_returned) {
                        $returned = DB::table('statuses')
                            ->select('id')
                            ->where('name', '=', 'Devolvido')
                            ->first();

                        DB::table('borrowed_items')
                            ->where('borrowing_id', '=', $borrowing)
                            ->where('id', '=', $item['id'])
                            ->update(['status_id' => $returned->id]);
                    } else {
                        $pending = DB::table('statuses')
                            ->select('id')
                            ->where('name', '=', 'Pendente')
                            ->first();

                        DB::table('borrowed_items')
                            ->where('borrowing_id', '=', $borrowing)
                            ->where('id', '=', $item['id'])
                            ->update(['status_id' => $pending->id]);
                    }

                    $item_id = BorrowedItem::select('item_id')
                        ->where('id', $item['id'])
                        ->first();

                    Item::where('id', '=', $item_id->item_id)
                        ->increment('amount', $item['amount']);

                    DB::select('CALL update_availability(?)', [$item_id->item_id]);
                }
            });

            DB::transaction(function () use ($borrowing) {
                $amounts = DB::table('borrowed_items')
                    ->select(DB::raw('sum(amount) as amount, sum(amount_returned) as amount_returned'))
                    ->where('borrowed_items.borrowing_id', '=', $borrowing)
                    ->first();

                if (($amounts->amount === $amounts->amount_returned)) {
                    $finish = DB::table('statuses')
                        ->select('id')
                        ->where('name', '=', 'Finalizado')
                        ->first();

                    Borrowing::where('id', $borrowing)
                        ->update(['status_id' => $finish->id]);
                }
            });

            return response()->json(["message" => "Atualizado com sucesso"], 201);

        } catch (Exception $e) {
            if (config('app.debug')) {
                return response()->json(["message" => $e->getMessage()], 400);
            }

            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Borrowing $borrowing
     * @return void
     */
    public function destroy(Borrowing $borrowing)
    {
        //
    }

    public function select(Request $request)
    {
        try {
            $data = $request->only('id');
            return DB::table('items')->select('items.id', 'items.name')
                ->join('types', 'items.type_id', '=', 'types.id')
                ->where('types.id', '=', $data)
                ->whereNull('items.deleted_at')
                ->get();

        } catch (Exception $e) {
            if (config('app.debug')) {
                return response()->json(["message" => $e->getMessage()], 400);
            }

            return response()->json(["message" => $e->getMessage()], 400);
        }
    }
}
