<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class MaterialController extends Controller
{


    public function index(Request $request)
    {
        $materials = Material::all();
        $averagePrice = $materials->avg('price_for_ton');
        $dominantType = $this->calculateDominantType($materials);
        $quantiles = $this->calculateQuantiles($materials);

        $materialStats = $materials->map(function ($material) use ($averagePrice) {
            $priceDeviation = $material->price_for_ton - $averagePrice;
            return [
                'name' => $material->name,
                'type' => $material->type,
                'price_for_ton' => $material->price_for_ton,
                'price_deviation' => $priceDeviation,
            ];
        });

        $materialTypes = $materials->groupBy('type')->map(function ($group) {
            return $group->count();
        });

        if ($request->is('admin/materials*')) {
            return view('admin.materials.index', [
                'materials' => $materials,
                'materialStats' => $materialStats,
                'materialTypes' => $materialTypes,
                'averagePrice' => $averagePrice,
                'dominantType' => $dominantType,
                'quantiles' => $quantiles,
            ]);
        }

        return view('materials.index', [
            'materials' => $materials,
            'randomMaterials' => $materials->random(3),
            'materialStats' => $materialStats,
            'materialTypes' => $materialTypes,
            'averagePrice' => $averagePrice,
            'dominantType' => $dominantType,
            'quantiles' => $quantiles,
        ]);
    }

    private function calculateDominantType($materials)
    {
        $typeCounts = $materials->pluck('type')->countBy();
        $dominantType = $typeCounts->sortDesc()->keys()->first();

        return $dominantType;
    }

    private function calculateQuantiles($materials)
    {
        $prices = $materials->pluck('price_for_ton')->sort()->values();
        $count = $prices->count();

        $quantiles = [
            'q1' => $this->getQuantile($prices, $count, 0.25),
            'q2' => $this->getQuantile($prices, $count, 0.5),
            'q3' => $this->getQuantile($prices, $count, 0.75),
        ];

        return $quantiles;
    }

    private function getQuantile($prices, $count, $quantile)
    {
        $index = ($count - 1) * $quantile;
        $lower = floor($index);
        $upper = ceil($index);
        $weight = $index - $lower;

        return $prices[$lower] * (1 - $weight) + $prices[$upper] * $weight;
    }




    public function show($id)
    {
        $material = Material::with('warehouses')->findOrFail($id);
        $inStock = $material->warehouses->sum('in_stock');
        $pricePerTon = $material->price_for_ton;
        $quantity = 1;
        $totalPrice = $pricePerTon * $quantity;

        return view('materials.show', [
            'material' => $material,
            'in_stock' => $inStock,
            'pricePerTon' => $pricePerTon,
            'quantity' => $quantity,
            'totalPrice' => $totalPrice,
        ]);
    }


    public function offers()
    {
        $materials = Material::all();

        return view('materials.offers', [
            'materials' => $materials
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->role === 'admin') {
            return view('admin.materials.create');
        } else {
            abort(403);
        }
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:20',
            'type' => 'required|string|max:20',
            'price_for_ton' => 'required|numeric|min:1',
            'img' => 'required|image|max:500',
        ]);

        $material = new Material();
        $material->name = $request->input('name');
        $material->type = $request->input('type');
        $material->price_for_ton = $request->input('price_for_ton');

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('img'), $fileName);
            $material->img = $fileName;
        }

        $material->save();

        return redirect()->route('admin.materials.index')->with('success', 'Materiał został dodany.');
    }




    public function edit($id)
    {
        if (Auth::user()->role === 'admin') {
            $material = Material::findOrFail($id);
            return view('admin.materials.edit', [
                'material' => $material
            ]);
        } else {
            abort(403);
        }
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|string|unique:materials,name,' . $id,
            'type' => 'required|string',
            'price_for_ton' => 'required|numeric|min:1',
            'img' => 'nullable|image|max:500',
        ]);

        $material = Material::findOrFail($id);
        $material->name = $request->input('name');
        $material->type = $request->input('type');
        $material->price_for_ton = $request->input('price_for_ton');

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('img'), $fileName);
            $material->img = $fileName;
        }

        $material->save();

        return redirect()->route('admin.materials.index')->with('success', 'Materiał został zaktualizowany.');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        if ($material->orders()->exists()) {
            abort(400);
        }

        if (Auth::user()->role === 'admin') {
            $material->delete();
            return redirect()->route('admin.materials.index');
        } else {
            abort(403);
        }
    }
}
