<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;
use App\Models\Dept;
use Illuminate\Support\Str;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{

    public function paymentview(Request $request)
    {
        $dept_id = $request->header('dept_id');
        $teacher_id = $request->header('id');
        $client = Client::where('dept_id', $dept_id)->where('client_status', 1)->get();
        return view('admin.paymentview', ['client' => $client]);
    }

    public function admin_invoice_create(Request $request)
    {
        $dept_id = $request->header('dept_id');
        $teacher_id = $request->header('id');
        $client_id = $request->input('client_id');
        $service_info = $request->input('service_info');
        $total_payment = $request->input('total_payment');

        $validator = \Validator::make(
            $request->all(),
            [
                'client_id'  => 'required',
                'service_info'  => 'required',
                'total_payment'  => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 700,
                'message' => $validator->messages(),
            ]);
        } else {
            $client = Client::where('dept_id', $dept_id)->where('client_status', 1)->where('id', $client_id)->first();
            $invoice_date = date('Y-m-d');

            $model = new Invoice;
            $model->dept_id  = $dept_id;
            $model->tran_id = Str::random(8);
            $model->client_id  = $client_id;
            $model->service_info = $service_info;
            $model->payment_status = 0;
            $model->discount_info = "N/A";
            $model->total_amount = $total_payment;
            $model->payment_amount = $total_payment;
            $model->invoice_date = $invoice_date;
            $model->save();

            return response()->json([
                'status' => 200,
                'data' => $client,
                'message' => "Invoice Create Successfull",
            ]);
        }
    }

    public function fetch(Request $request)
    {
        $dept_id = $request->header('dept_id');
        $teacher_id = $request->header('id');
        $data = Invoice::leftjoin('clients', 'clients.id', '=', 'invoices.client_id')
            ->where('invoices.dept_id', $dept_id)
            ->select(
                'clients.client_name',
                'clients.email',
                'clients.phone',
                'clients.address',
                'invoices.*'
            )->orderBy('invoices.id', 'desc')->paginate(10);
        return view('admin.paymentview_data', compact('data'));
    }


    function fetch_data(Request $request)
    {
        if ($request->ajax()) {
            $dept_id = $request->header('dept_id');
            $teacher_id = $request->header('id');
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $search = $request->get('search');
            $search = str_replace(" ", "%", $search);
            $data = Invoice::leftjoin('clients', 'clients.id', '=', 'invoices.client_id')
                ->where('invoices.dept_id', $dept_id)
                ->where(function ($query) use ($search) {
                    $query->orwhere('invoices.id', 'like', '%' . $search . '%');
                    $query->orwhere('clients.client_name', 'like', '%' . $search . '%');
                    $query->orwhere('clients.email', 'like', '%' . $search . '%');
                    $query->orwhere('clients.phone', 'like', '%' . $search . '%');
                    $query->orwhere('invoices.invoice_date', 'like', '%' . $search . '%');
                    $query->orwhere('invoices.service_info', 'like', '%' . $search . '%');
                })
                ->select('clients.client_name', 'clients.email', 'clients.phone', 'invoices.*')
                ->orderBy($sort_by, $sort_type)->paginate(10);
            return view('admin.paymentview_data', compact('data'))->render();
        }
    }



    public function payment_status(Request $request)
    {
        
        $id = $request->id;
        $payment_method = $request->payment_method;
        $invoice = Invoice::where('id', $id)->first();
        $dept_id = $request->header('dept_id');
        $teacher_id = $request->header('id');

        if ($invoice->payment_type == "Online") {
            return response()->json([
                'status' => 300,
                'message' => "Online Payment Exist.Can Not Change Payment Status",
            ]);
        } else {
            if ($invoice->payment_status == 0) {
                $status = 1;
                $payment_time = date('Y-m-d H:i:s');
                $payment_type = 'Offline';
            } else {
                $status = 0;
                $payment_time = date('2010-10-10 10:10:10');
                $payment_type = 'Offline';
            }

            $payment_date = date('Y-m-d');
            $payment_day = date('d');
            $payment_month = date('n');
            $payment_year = date('Y');

            $model = Invoice::find($id);
            $model->payment_status = $status;
            $model->payment_type = $payment_type;
            $model->payment_time = $payment_time;
            $model->payment_method = $payment_method;
            $model->payment_date = $payment_date;
            $model->payment_year = $payment_year;
            $model->payment_month = $payment_month;
            $model->payment_day = $payment_day;
            $model->payment_by = $teacher_id;
            $model->update();

            return response()->json([
                'status' => 200,
                'message' => "Payment Status Update Successfull",
            ]);
        }
    }



    public function payment_delete(Request $request)
    {
        $id = $request->id;
        $email = $request->email;
        $dept_id = $request->header('dept_id');
        $teacher_id = $request->header('id');
        $invoice = Invoice::where('id', $id)->first();
        $admin = Teacher::where('dept_id', $dept_id)->where('role', 'admin')->first();
        if ($email == $admin->email) {
            if ($invoice->payment_status == 0) {
                $model = Invoice::find($id);
                $model->delete();
                return response()->json([
                    'status' => 200,
                    'message' => "Invoice delete Successfull",
                ]);
            } else {
                return response()->json([
                    'status' => 300,
                    'message' => "Please Unpaid Payment Status",
                ]);
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => "Invalid Admin Email",
            ]);
        }
    }


    public function payment_refresh(Request $request)
    {
        $dept_id = $request->header('dept_id');
        $teacher_id = $request->header('id');
        $client=Client::where('dept_id',$dept_id)->where('client_status',1)->get();
            //$expired_date=date("Y-m-d",strtotime($create_date.$subscribe."month")); day
            // return $client;
            // die();
        foreach($client as  $row ){ 
           if(strtotime(date("Y-m-d"))-strtotime($row['expired_date'])>0){
                      $created_date=$row['expired_date'];
                      $expired_date=date("Y-m-d",strtotime($row['expired_date'].$row['subcribe']."month"));
                      $service_info=$row['service_info'];
                      $total_amount=$row['total_amount'];
                      $discount_info=$row['discount_info'];
                      $discount_amount=$row['discount_amount'];
                      $discount_info=$row['discount_info'];
                      $subcribe=$row['subcribe'];
                      $id=$row['id'];

                      $model = new Invoice;
                      $model->dept_id  = $dept_id;
                      $model->tran_id = Str::random(8);
                      $model->client_id  = $id;
                      $model->service_info = $service_info;
                      $model->total_amount = $total_amount;
                      $model->payment_status = 0;
                      $model->discount_info = $discount_info;
                      $model->discount_amount = $discount_amount;
                      $model->payment_amount = $total_amount-$discount_amount;
                      $model->invoice_date = $created_date;
                      $model->save();

                 DB::update("update clients set created_date ='$created_date', expired_date ='$expired_date' 
                        where id = '$id'");
                 } 
           }

         return back()->with('success','Payment Update Successfull');
    }
    




}
