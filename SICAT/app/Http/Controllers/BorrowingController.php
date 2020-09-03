<?php

namespace App\Http\Controllers;

use App\BorrowedItem;
use App\Borrowing;
use App\Http\Requests\StoreBorrowingRequest;
use App\Item;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|Response|\Illuminate\View\View
     * @throws \Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $borrowings = DB::table('borrowings')
                ->select('borrowings.id', 'borrowings.requester', 'borrowings.email_requester', 'borrowings.acquisition_date', 'statuses.name as status')
                ->join('statuses', 'borrowings.status_id', '=', 'statuses.id')
                ->get();

            foreach ($borrowings as $borrowing) {
                $borrowing->items = DB::table('borrowed_items')
                    ->select('items.name')
                    ->join('items', 'borrowed_items.item_id', '=', 'items.id')
                    ->where('borrowed_items.borrowing_id', '=', $borrowing->id)
                    ->get();
            };

            return Datatables::of($borrowings)
                ->addColumn('action', function ($data) {
                    $result = '<div class="btn-group btn-group-sm" role="group" aria-label="Exemplo básico">';
                    if (Gate::allows('rolesUser', 'borrowing_view')) {
                        $result .= '<button type="button" id="' . $data->id . '" class="btn btn-primary" data-toggle="modal" data-target="#modalView" data-whatever="' . $data->id . '""><i class="fas fa-fw fa-eye mr-1"></i>Visualizar</button>';
                    }
                    if (Gate::allows('rolesUser', 'borrowing_edit')) {
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
     * @return Response
     */
    public function create()
    {
        $types = DB::table('types')->select('id', 'name')->get();

        $status = DB::table('statuses')->select('id', 'name')
            ->where('name', '=', 'Emprestado')
            ->orWhere('name', '=', 'Atrasado')
            ->orWhere('name', '=', 'Devolvido')
            ->get();

        return view('dashboard.borrowing.create-borrowing', ['types' => $types, 'status' => $status]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
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
                }
            });

            return response()->json(["message" => "Cadastrado com sucesso"], 201);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(["message" => $e->getMessage()], 400);
            }

            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Borrowing $borrowing
     * @return Response
     */
    public function show($borrowing)
    {
        $borrowings = DB::table('borrowings')
            ->select('borrowings.id', 'borrowings.requester', 'borrowings.phone_requester', 'borrowings.email_requester', 'borrowings.office_requester', 'borrowings.acquisition_date', 'statuses.name as status')
            ->join('statuses', 'borrowings.status_id', '=', 'statuses.id')
            ->where('borrowings.id', '=', $borrowing)
            ->get();

//        dd($borrowings);

        $borrowings[0]->items = DB::table('borrowed_items')
            ->select('borrowed_items.id', 'items.name', 'borrowed_items.amount')
            ->join('items', 'borrowed_items.item_id', '=', 'items.id')
            ->where('borrowed_items.borrowing_id', '=', $borrowings[0]->id)
            ->get();

        return $borrowings;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Borrowing $borrowing
     * @return Response
     */
    public function edit(Borrowing $borrowing)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $borrowing
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $borrowing)
    {
        try {

            $data = $request->all();

            DB::transaction(function () use ($data, $borrowing) {
//                $borrowing = Borrowing::find($borrowing);
                foreach ($data as $item) {
                    DB::table('borrowed_items')
                        ->where('borrowing_id', '=', $borrowing)
                        ->where('item_id', '=', $item['id'])
                        ->increment('amount_returned', $item['amount'], ['return_date' => $item['return_date']]);

                    $amounts = DB::table('borrowed_items')
                        ->select('amount', 'amount_returned')
                        ->where('borrowing_id', '=', $borrowing)
                        ->where('item_id', '=', $item['id'])
                        ->first();

                    if ($amounts['amount'] === $amounts['amount_returned']) {
                        $returned = DB::table('statuses')
                            ->select('id')
                            ->where('name', '=', 'Devolvido')
                            ->first();

                        DB::table('borrowed_items')
                            ->where('borrowing_id', '=', $borrowing)
                            ->where('item_id', '=', $item['id'])
                            ->update(['status_id' => $returned]);
                    }

                    $item = BorrowedItem::select('item_id')
                        ->where('id', $item['id'])
                        ->first();

                    DB::table('items')
                        ->where('id', '=', $item)
                        ->increment('amount', $item['amount']);
                }
            });

            $status = DB::table('borrowed_items')
                ->select('items.name')
                ->join('items', 'borrowed_items.item_id', '=', 'items.id')
                ->where('borrowed_items.borrowing_id', '=', $borrowing)
                ->get();




            return response()->json(["message" => "Atualizado com sucesso"], 201);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(["message" => $e->getMessage()], 400);
            }

            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Borrowing $borrowing
     * @return Response
     */
    public
    function destroy(Borrowing $borrowing)
    {
        //
    }

    public
    function select(Request $request)
    {
        try {
            $data = $request->only('id');
            $items = DB::table('items')->select('items.id', 'items.name')
                ->join('types', 'items.type_id', '=', 'types.id')
                ->where('types.id', '=', $data)
                ->whereNull('items.deleted_at')
                ->get();

            return $items;

        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(["message" => $e->getMessage()], 400);
            }

            return response()->json(["message" => $e->getMessage()], 400);
        }
    }
}
