<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Order;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{


    public function index(Request $request)
    {

        $orders = Order::all();
        Gate::authorize('viewAny', Order::class);
        return view('admin.orders.index', [
            'orders' => $orders,
        ]);
        // if (Auth::check()) {
        //     if (Auth::user()->role == 'admin') {
        //         if ($request->is('admin/orders*')) {
        //             return view('admin.orders.index', [
        //                 'orders' => $orders,
        //             ]);
        //         }
        //     } else {
        //         $userOrders = $orders->where('user_id', Auth::id());
        //         return view('user.orders.index', [
        //             'orders' => $userOrders,
        //         ]);
        //     }
        // } else {
        //     abort(403);
        // }
    }



    public function create()
    {
        Gate::authorize('create', Order::class);
        $users = User::all();
        $materials = Material::all();

        return view('admin.orders.create', [
            'users' => $users,
            'materials' => $materials,
        ]);
        // if (Auth::check()) {
        //     if (Auth::user()->role == 'admin') {
        //         $users = User::all();
        //         $materials = Material::all();

        //         return view('admin.orders.create', [
        //             'users' => $users,
        //             'materials' => $materials,
        //         ]);
        //     } else {
        //         $materials = Material::all();

        //         return view('user.orders.create', [
        //             'user' => Auth::user(),
        //             'materials' => $materials,
        //         ]);
        //     }
        // } else {
        //     abort(403);
        // }
    }



    // public function index()
    // {
    //     $orders = Order::all();
    //     return view('user.orders.index', [
    //         'orders' => $orders,
    //     ]);
    // }

    // public function index2()
    // {
    //     $orders = Order::all();
    //     return view('admin.orders.index', ['orders' => $orders]);
    // }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'material_id' => 'required|exists:materials,id',
            'quantity' => 'required|numeric|min:0.1',
        ]);

        $price = Material::find($request->input('material_id'))->price_for_ton;

        $order = new Order();
        $order->user_id = $request->input('user_id');
        $order->material_id = $request->input('material_id');
        $order->quantity = $request->input('quantity');
        $order->final_price = $price * $request->input('quantity');
        $order->save();

        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.orders.index')->with('success', 'Zamówienie zostało złożone.');
        }

        return redirect()->route('materials.offers')->with('success', 'Zamówienie zostało złożone.');
    }

    public function show($user_id)
    {
        $order = Order::findOrFail($user_id);

        Gate::authorize('view', $order);

        if (Auth::check() && Auth::id() == $user_id) {
            $user = User::find($user_id);
            if (!$user) {
                abort(403);
            }

            $orders = Order::where('user_id', $user_id)->get();
            return view('user.orders.show', ['orders' => $orders]);
        } else {
            abort(403);
        }
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);

        Gate::authorize('update', $order);

        $material = Material::findOrFail($order->material_id);
        $in_stock = Warehouse::where('material_id', $order->material_id)->first();

        if (Auth::check()) {
            if (Auth::user()->role === 'admin') {
                return view('admin.orders.edit', ['order' => $order, 'material' => $material]);
            } elseif (Auth::user()->id === $order->user_id) {
                return view('user.orders.edit', ['order' => $order, 'material' => $material]);
            } else {
                abort(403);
            }
        } else {
            abort(403);
        }
    }


    public function update(Request $request, Order $order)
    {
        Gate::authorize('update', $order);

        $request->validate([
            'material_id' => 'exists:materials,id',
            'quantity' => 'required|numeric|min:0.1',
        ]);

        // Czy materiał istnieje
        $material = Material::findOrFail($order->material_id);

        // Obliczenie ceny końcowej
        $final_price = $material->price_for_ton * $request->input('quantity');

        // Aktualizacja zamówienia
        $order->update([
            'material_id' => $material->id,
            'quantity' => $request->quantity,
            'final_price' => $final_price,
        ]);

        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.orders.index')->with('success', 'Zaktualizowano zamówienie.');
        }

        return redirect()->route('user.orders.show', $order->user_id)->with('success', 'Zaktualizowano zamówienie.');
    }





    public function destroy(Request $request, Order $order)
    {
        Gate::authorize('delete', $order);

        $order->delete();

        if ($request->is('admin/orders*')) {
            return redirect()->route('admin.orders.index')->with('success', 'Usunięto zamówienie.');
        }

        if ($request->is('user/orders*')) {
            return redirect()->route('user.orders.show', Auth::user()->id)->with('success', 'Usunięto zamówienie.');
        }

        return redirect()->back()->with('success', 'Usunięto zamówienie.');
    }

}
