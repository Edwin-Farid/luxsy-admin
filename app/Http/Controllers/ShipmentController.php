<?php

namespace App\Http\Controllers;

use App\Http\Resources\ResponseResource;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $shipment = Shipment::where('tokenId', 'like', '%' . $request->tokenId . '%')->where('owner', 'like', '%' . $request->owner . '%')->latest()->simplePaginate($request->perPage);
        return new ResponseResource(true, 'Shipment list', $shipment);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tokenId' => 'required',
            'artName' => 'required',
            'price' => 'required',
            'owner' => 'required',
            'address' => 'required',
            'postalCode' => 'required',
        ]);

        if ($validator->fails()) {
            $resource = new ResponseResource(false, 'Smothing wrong', $validator->errors());
            return $resource->response()->setStatusCode(400);
        }
        $shipment = Shipment::create($request->all());

        $resource = new ResponseResource(true, 'Shipment success to add', $shipment);
        return $resource->response()->setStatusCode(200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Shipment $shipment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shipment $shipment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shipment $shipment)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
            'withdraw' => 'required',
            'deliveryNumber' => 'required',
        ]);

        if ($validator->fails()) {
            $resource = new ResponseResource(false, 'Smothing wrong', $validator->errors());
            return $resource->response()->setStatusCode(400);
        }

        $shipment->status = $request->status;
        $shipment->withdraw = $request->withdraw;
        $shipment->deliveryNumber = $request->deliveryNumber;
        $shipment->save();

        $resource = new ResponseResource(true, 'Shipment success to update', $shipment);
        return $resource->response()->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shipment $shipment)
    {
        $shipment->delete();
        $resource = new ResponseResource(true, 'Shipment deleted', $shipment);
        return $resource->response()->setStatusCode(200);
    }
}
