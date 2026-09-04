<?php

namespace App\Http\Controllers;

use App\InventoryTracking;
use App\Product;
use App\Supplier;
use App\Purchase;
use App\User;
use App\CustomerInvoice;
use App\Mail\Invoice;
use DB;
use Mail;
use Illuminate\Http\Request;

class InventoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except("invoiceDetailPublic");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['products'] = Product::orderBy("name" , "ASC")->get();
        $data['suppliers'] = Supplier::orderBy("name" , "ASC")->get();
        return view('backend.inventories.add_purchased', $data);
    }
    public function edit_purchase($id)
    {
        $data["purchase"] = DB::table("purchases")->where("id" , $id)->first();
        $data["purchase_items"] = DB::table("purchase_items")->where("purchase_id" , $id)->get();
        $data['products'] = Product::orderBy("name" , "ASC")->get();
        $data['suppliers'] = Supplier::orderBy("name" , "ASC")->get();
        return view('backend.inventories.edit_purchased', $data);
    }


    public function purchasedItems(Request $request)
    {

        $keyword = $request->get('q', '');
        if (!empty($request->get('start_date'))) $start_date = date("Y-m-d", strtotime($request->get('start_date')));
        if (!empty($request->get('end_date'))) $end_date = date("Y-m-d", strtotime($request->get('end_date')));
        $data["q"] = $keyword;

        // $products = Product::where("name", "like", "%$keyword%")->get();
        // $ids = array();
         $sids = array();
        // foreach ($products as $product) {
        //     $ids[] = $product->id;
        // }
        $suppliers = Supplier::where("name","like" ,  "%$keyword%")->get();
        foreach ($suppliers as $product) {
            $sids[] = $product->id;
        }

        $query = Purchase::query();
        if (!empty($keyword)) {
            $query->whereIn("supplier_id" , $sids);
        }

        $data["start_date"] = "";
        if (!empty($start_date)) {
            $query->where("purchase_date", ">=", $start_date);
            $data["start_date"] = date("d-m-Y", strtotime($start_date));
        }
        $data["end_date"] = "";
        if (!empty($end_date)) {
            $query->where("purchase_date", "<=", $end_date);
            $data["end_date"] = date("d-m-Y", strtotime($end_date));
        }
        $items = $query->orderBy("id", "DESC")->paginate(25);

        // $items = DB::table("purchases")->orderBy("id", "DESC")->paginate(20);
        foreach($items as $item) {
            $item->supplier = "";
            if(!empty($item->supplier_id)) $item->supplier = Supplier::find($item->supplier_id);
        }
        $data['items'] = $items;
        return view('backend.inventories.purchased', $data);
    }
    public function purchasedDetail($id)
    {
        $data['purchase'] = DB::table("purchases")->orderBy("id", "DESC")->first();
        $items = DB::table("purchase_items")->where("purchase_id" , $id)->get();
        foreach ($items as $item) {
            $item->product = "";
            if (!empty($item->product_id)) $item->product = Product::find($item->product_id);
        }
        $data["supplier"] = Supplier::find($data['purchase']->supplier_id);
        $data['items'] = $items;
        return view('backend.inventories.purchase_detail', $data);
    }



    function addProductAjax(Request $request)
    {
        $product_id = $request->input('product_id');
        $row = Product::find($product_id);

        $html = "<tr><td>" . $row->name . "</td>"
            . "<td><input type='text' value='1' id='qty_" . $row->id . "' data-id='" . $row->id . "' name='quantity[]' class='form-control change_qty'></td>"
            . "<td><input type='text' value='1' data-id='" . $row->id . "'  id='price_" . $row->id . "' name='purchase_cost[]' class='form-control change_price'></td>  <input type='hidden' name='product_ids[]' value='" . $row->id . "'> "
            . "<td><input type='text' value='1' data-id='" . $row->id . "'  id='units_" . $row->id . "' name='units[]' class='form-control units'></td> "
            . "<td id='total_units_" . $row->id . "' >1</td>"
            . "<td><input type='text' name='sold_price[]' class='form-control'></td>"
            . "<td><input type='text' value='1' readonly id='toatlprice_" . $row->id . "' name='total_price[]' class='form-control'></td>"
            . "</tr>";

        echo $html;
    }

    public function savePurchaseInventory(Request $request) {  

    
    //    echo "<pre>"; print_r($request->all()); exit;
        $data = array(
            'purchase_date' => date("Y-m-d", strtotime($request->input("purcahse_date"))),
            'bill_no' => $request->input("bill_no"),
            'total_amount' => $request->input("final_price"),
            'tax' => $request->input("tax"),
            'note' => $request->input("note"),
            'discount' => $request->input("tax"),
            'supplier_id' => $request->input("supplier_id"),
        );

        $purchase_id = $request->input("purchase_id");
        if($purchase_id) {
            $insert_id = $purchase_id;
            $data["updated_at"] = date("Y-m-d");
            DB::table("purchases")->where("id" , $purchase_id)->update($data);
        } else {
            $data["created_at"] = date("Y-m-d H:i:s");
            $insert_id = DB::table("purchases")->insertGetId($data);
        }

        $total_price = $request->input("total_price");
        $product_ids = $request->input("product_ids");
        $quantity = $request->input("quantity");
        $purchase_cost = $request->input("purchase_cost");
        $sold_price = $request->input("sold_price");
        $units = $request->input("units");
        if ($purchase_id) { 
            foreach ($product_ids as $key => $id) {
                $product = array(
                    "purchase_id" => $insert_id,
                    "quantity" => $quantity[$key],
                    "units" => $units[$key],
                    "unit_price" => $purchase_cost[$key],
                    "sold_price" => $sold_price[$key],
                    "gross_total" => $total_price[$key],
                    "product_id" => $id
                );
                $purchase_item = DB::table("purchase_items")->where("product_id", $id)->where("purchase_id" , $insert_id)->first();
                
                if($purchase_item) {
                    $product["updated_at"] = date("Y-m-d H:i:s");
                    $pre_quantity = $purchase_item->quantity * $purchase_item->units;
                    $product_quantity = ($quantity[$key] * $units[$key]) - $pre_quantity;
                    if($product_quantity > 0) {
                        $pro = Product::find($id);
                        $pro->warehouse += $product_quantity;
                        $pro->save();
                    }
                   
                    DB::table("purchase_items")->where("id", $purchase_item->id)->update($product);
                } else {
                    $product["created_at"] = date("Y-m-d H:i:s");
                    DB::table("purchase_items")->insert($product);
                    $pro = Product::find($id);
                    $pro->warehouse += $quantity[$key] * $units[$key];
                    $pro->save();
                }

               
               
            }
           
        } else {
            $product = array();
            foreach ($product_ids as $key => $id) {
                $product[] = array(
                    "purchase_id" => $insert_id,
                    "quantity" => $quantity[$key],
                    "units" => $units[$key],
                    "unit_price" => $purchase_cost[$key],
                    "sold_price" => $sold_price[$key],
                    "gross_total" => $total_price[$key],
                    "product_id" => $id,
                    "created_at" => date("Y-m-d H:i:s"),
                );

                $pro = Product::find($id);
                $pro->warehouse += $quantity[$key] * $units[$key];
                $pro->save();
            }

            DB::table("purchase_items")->insert($product);
        }
       
        return redirect("purchase_inventory");
    }


    public function minQuantity(Request $request)
    {
        $data['products'] = Product::orderBy("name", "ASC")->get();
        $data['suppliers'] = Supplier::orderBy("name", "ASC")->get();
        return view('backend.inventories.min_qty', $data);
    }

    public function updateMinQuantity(Request $request)
    {
        $products = $request->input("product_id");
        $quantity = $request->input("min_qty");
        $store_min = $request->input("store_min");
        foreach ($products as $k => $product) {
            $pro = Product::find($product);
            $pro->min_qty = $quantity[$k];
            $pro->store_min = $store_min[$k];
            $pro->save();
            }

        return redirect("min_quantity_alert")->with('message-success', 'Updated Successfully!');;
    }

    public function quantityAlerts(Request $request)
    {
        $data['products'] = Product::whereRaw("quantity <= min_qty")->orWhereRaw("warehouse <= store_min")->orderBy("name", "ASC")->get();
        return view('backend.inventories.quantity_alerts', $data);
    }


    public function createCustomerInvoice(Request $request)
    {
        $data['products'] = Product::orderBy("name", "ASC")->get();
        $data['customers'] = User::where("role_id" , 4)->orderBy("name", "ASC")->get();
        $data['users'] = User::whereIn("role_id" , [1,2])->orderBy("name", "ASC")->get();
        return view('backend.customer_invoice.add_invoice', $data);
    }
    public function editCustomerInvoice($id)
    {
        $data['invoice'] = DB::table("customer_invoices")->where("id" , $id)->first();
        $data['invoice_items'] = DB::table("customer_invoice_items")->where("invoice_id" , $id)->get();
        $data['products'] = Product::orderBy("name", "ASC")->get();
        $data['customers'] = User::where("role_id" , 4)->orderBy("name", "ASC")->get();
        $data['users'] = User::whereIn("role_id" , [1,2])->orderBy("name", "ASC")->get();
        return view('backend.customer_invoice.edit_invoice', $data);
    }


    public function saveCustomerInvoice(Request $request)
    {
    //    echo "<pre>"; print_R($request->all()); exit;
        $data = array(
            'invoice_date' => date("Y-m-d", strtotime($request->input("invoice_date"))),
            'ship_date' => date("Y-m-d", strtotime($request->input("ship_date"))),
            'due_date' => date("Y-m-d", strtotime($request->input("due_date"))),
            'po_number' => $request->input("po_number"),
            'terms' => $request->input("terms"),
            'bill_customer' => $request->input("bill_customer"),
            'bill_address' => $request->input("bill_address"),
            'bill_city' => $request->input("bill_city"),
            'bill_state' => $request->input("bill_state"),
            'bill_zip' => $request->input("bill_zip"),
            'bill_country' => $request->input("bill_country"),
            'ship_customer' => $request->input("ship_customer"),
            'ship_address' => $request->input("ship_address"),
            'ship_city' => $request->input("ship_city"),
            'ship_state' => $request->input("ship_state"),
            'ship_zip' => $request->input("ship_zip"),
            'ship_country' => $request->input("ship_country"),
            'total_amount' => $request->input("final_price"),
            'tax' => $request->input("tax"),
            'note' => $request->input("note"),
            'discount' => $request->input("discount"),
        );

        $invoice_id = $request->input("invoice_id");
        if($invoice_id) {
            $insert_id = $invoice_id;
            DB::table("customer_invoices")->where("id" , $insert_id)->update($data);
        } else {
            $insert_id = DB::table("customer_invoices")->insertGetId($data);
        }

        // echo "<pre>"; print_r($request->all());
        // exit;

       

        $total_price = $request->input("total_price");
        $product_ids = $request->input("product_ids");
        $product_name = $request->input("product_name");
        $quantity = $request->input("quantity");
        $purchase_cost = $request->input("purchase_cost");
        $units = $request->input("units");
        if(!empty($invoice_id)) {
            $product = array();
            foreach ($quantity as $key => $id) {
                $product = array(
                    "invoice_id" => $insert_id,
                    "quantity" => $quantity[$key],
                    "units" => $units[$key],
                    "unit_price" => $purchase_cost[$key],
                    "gross_total" => $total_price[$key],
                    // "product_id" => $product_ids[$key],
                    "product_name" => $product_name[$key],
                );
                $invoice_detail = DB::table("customer_invoice_items")->where("id", $product_ids[$key])->first();
                
                if (!empty($invoice_detail)) {
                    DB::table("customer_invoice_items")->where("id", $invoice_detail->id)->update($product);
                } else {
                    DB::table("customer_invoice_items")->insert($product);
                }
            }
          
           
        } else {
            $product = array();
            foreach ($quantity as $key => $id) {
                $product[] = array(
                    "invoice_id" => $insert_id,
                    "quantity" => $quantity[$key],
                    "units" => $units[$key],
                    "unit_price" => $purchase_cost[$key],
                    "gross_total" => $total_price[$key],
                    // "product_id" => $product_ids[$key],
                    "product_name" => $product_name[$key],
                );

            // $pro = Product::find($id);
            // $pro->warehouse += $quantity[$key];
            // $pro->save();
            }

            $id = encrypt($insert_id);
            $user = User::find($request->input("bill_customer"));
            $content = array(
                "url" => url("invoice_detail_public/" . $id),
                "amount" => $request->input("final_price")
            );
            $email = Mail::to($user->email)->send(new Invoice($content));
            DB::table("customer_invoice_items")->insert($product);
        }
        
        return redirect("customer_invoices");
    }

    function addProductCustomerAjax(Request $request)
    {
        $product_id = $request->input('product_id');
        $counter = $request->input('counter');
        $row = Product::find($product_id);
       
        $product_name = "";
        $product_id = "";
        
        if(!empty($row)) {
            $product_name = $row->name;
            $product_id = $row->id;
            $counter = $row->id;
        }
        $html = "<tr><td><input type='text' class='form-control' name='product_name[]' value='" . $product_name  . "'>  </td>"
            . "<td><input type='text' value='1' id='qty_" . $counter . "' data-id='" . $counter . "' name='quantity[]' class='form-control change_qty'></td>"
            . "<td><input type='text' value='1' data-id='" . $counter . "'  id='price_" . $counter . "' name='purchase_cost[]' class='form-control change_price'></td>  <input type='hidden' name='product_ids[]' value='" . $product_id . "'> "
            . "<td><input type='text' value='1' data-id='" . $counter . "'  id='units_" . $counter . "' name='units[]' class='form-control units'></td> "
            . "<td><input type='text' value='1' readonly id='toatlprice_" . $counter . "' name='total_price[]' class='form-control'></td>"
            . "</tr>";

        echo $html;
    }


    public function customerInvoices(Request $request)
    {

        $keyword = $request->get('q', '');
        if (!empty($request->get('start_date'))) $start_date = date("Y-m-d", strtotime($request->get('start_date')));
        if (!empty($request->get('end_date'))) $end_date = date("Y-m-d", strtotime($request->get('end_date')));
        $data["q"] = $keyword;

        // $products = Product::where("name", "like", "%$keyword%")->get();
        // $ids = array();
        $sids = array();
        // foreach ($products as $product) {
        //     $ids[] = $product->id;
        // }
        $suppliers = User::where("name", "like", "%$keyword%")->get();
        foreach ($suppliers as $product) {
            $sids[] = $product->id;
        }

        $query = CustomerInvoice::query();
        if (!empty($keyword)) {
            $query->whereIn("bill_customer", $sids);
        }

        $data["start_date"] = "";
        if (!empty($start_date)) {
            $query->where("invoice_date", ">=", $start_date);
            $data["start_date"] = date("d-m-Y", strtotime($start_date));
        }
        $data["end_date"] = "";
        if (!empty($end_date)) {
            $query->where("invoice_date", "<=", $end_date);
            $data["end_date"] = date("d-m-Y", strtotime($end_date));
        }
        $items = $query->orderBy("id", "DESC")->paginate(25);

        // $items = DB::table("purchases")->orderBy("id", "DESC")->paginate(20);
        foreach ($items as $item) {
            $item->shipping_customer = "";
            $item->billing_customer = "";
            if (!empty($item->bill_customer)) $item->shipping_customer = User::find($item->bill_customer);
            if (!empty($item->ship_customer)) $item->billing_customer = User::find($item->ship_customer);
        }
        // echo "<pre>"; print_r($items); exit;
        $data['items'] = $items;
        return view('backend.customer_invoice.invoices', $data);
    }


    public function invoiceDetail($id)
    {
        $data['purchase'] = DB::table("customer_invoices")->orderBy("id", "DESC")->first();
        $items = DB::table("customer_invoice_items")->where("invoice_id", $id)->get();
        foreach ($items as $item) {
            $item->product = "";
            if (!empty($item->product_id)) $item->product = Product::find($item->product_id);
        }
        $data["billing_customer"] = User::find($data['purchase']->bill_customer);
        $data["shipping_customer"] = User::find($data['purchase']->ship_customer);
        $data['items'] = $items;
        return view('backend.customer_invoice.invoice_detail', $data);
    }

    public function invoiceDetailPublic($id)
    {
        $id = decrypt($id);
        $data['purchase'] = DB::table("customer_invoices")->orderBy("id", "DESC")->first();
        $items = DB::table("customer_invoice_items")->where("invoice_id", $id)->get();
        foreach ($items as $item) {
            $item->product = "";
            if (!empty($item->product_id)) $item->product = Product::find($item->product_id);
        }
        $data["billing_customer"] = User::find($data['purchase']->bill_customer);
        $data["shipping_customer"] = User::find($data['purchase']->ship_customer);
        $data['items'] = $items;
        return view('backend.customer_invoice.invoice_detail_public', $data);
    }




}
