<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Customer;
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $keyword = $request->get('q', '');
        $data["q"] = $keyword;
        if ($keyword) {
            $data['customers'] = User::where("name", "like", "%$keyword%")->where("role_id", "4")->paginate();
        } else {
            $data['customers'] = User::where("role_id", "4")->paginate();
        }

       

        return view('backend.customers.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\StoreCustomer $request)
    {
        $form = $request->all();

        $customer = User::create($form);

        return redirect('customers')
            ->with('message-success', 'Customer created!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = User::findOrFail($id);

        return view('backend.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = User::findOrFail($id);

        return view('backend.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param App\Http\Requests $request
     * @param int               $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $form = $request->all();

        $customer = User::findOrFail($id);
       
        // if(!empty($form["password"])) {
        //     $form["password"] = bcrypt($form["password"]);
        // }
        $customer->update($form);
      
        return redirect('customers')
            ->with('message-success', 'Customer updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = User::findOrFail($id);
        $customer->delete();

        return redirect('customers')
            ->with('message-success', 'Customer deleted!');
    }
	
	public function findcustomer(Request $request) { 
		$phone = $request->input('phone'); 
		$record = Customer::where("phone",$phone)->first();
		echo json_encode($record);
	}
    
	
	
	public function storeCustomer(Request $request) { 
		$id = $request->input("id");
		$data_array = array();
		$data = array(
			"name" => $request->input("name"),
			"phone" => $request->input("phone"),
			"address" => $request->input("address"),
			"city" => $request->input("city"),
			"state" => $request->input("state"),
            "zip" => $request->input("zip")
		);
		$data_array["message"] = "OK";
		if($id) { 
			Customer::where("id" , $id)->update($data);
			$data_array["id"] = $id;
		} else { 
			$insert_id = Customer::insertGetId($data);
			$data_array["id"] = $insert_id;
		}
		
		echo json_encode($data_array);
	}
}
