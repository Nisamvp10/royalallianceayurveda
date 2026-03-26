<?php
namespace App\Controllers\admin;

use CodeIgniter\Controller;
use App\Libraries\MpdfLibrary;
use App\Models\Salesmodel;
use App\Models\PurchaseOrderModel;
use App\Models\ProductModel;
use App\Models\SupplierModel;

use Mpdf\Mpdf;
class ReportsController extends Controller {
    protected $salesModel;
    protected $purchaseModel;
    protected $productModel;
    protected $supplierModel;
    function __construct(){
        $this->salesModel = new Salesmodel();
        $this->purchaseModel = new PurchaseOrderModel();
        $this->productModel = new ProductModel();
        $this->supplierModel = new SupplierModel();
    }
    public function index() {
        $page = (!hasPermission('','reports') ? lang('Custom.permissionDenied') :'Reports');
        $route = (!hasPermission('','reports') ?'pages-error-404' :'admin/reports/index');
        return view($route,compact('page'));
    }
    public function salesReport()
    {
        if(!hasPermission('','reports')) {
            return $this->response->setJSON(['success' => false ,'message' => lang('CUstom.permissionDenied')]);
        }
        $fromDate = $this->request->getGet('start');
        $toDate   = $this->request->getGet('end');
       $sales = $this->salesModel->salesHistory('','',$fromDate,$toDate,'');

       //$mpdf = (new MpdfLibrary())->load();
             $mpdf = new Mpdf();
            // Header content (only first page)
            $header = '
            
            <table width="100%" style="border-bottom: 1px solid #000; font-family: sans-serif; font-size: 12px;">
                <tr>
                    <td width="20%">
                        <img src="'.base_url(getappdata('applogo')).'" width="70"/>
                        <h3>'. getappdata('company_name') .'</h3>
                    </td>
                    <td width="60%" align="center">
                        <h2 style="margin:0;">SALES REPORT</h2>
                        <small>From: ' . $fromDate . ' &nbsp; To: ' . $toDate . '</small>
                    </td>
                    <td width="20%" align="right">
                        <small>Generated: ' . date("d-m-Y H:i") . '</small>
                    </td>
                </tr>
            </table>';

            $mpdf->SetHTMLHeader($header, 'O', true); // header only on first page
            $mpdf->DefHTMLHeaderByName('FirstPageHeader', $header);
            $mpdf->DefHTMLHeaderByName('OtherPagesHeader', '');

            $mpdf->SetHTMLHeaderByName('FirstPageHeader');
            $mpdf->SetHTMLHeaderByName('OtherPagesHeader');

            // Body content
            $total = 0;
            $totalQty = 0;
           
            $html = "<div style='height:50px;padding-top:25px'></div></div></div><table  border='1' width='100%' cellspacing='0' cellpadding='5'>
                        <thead>
                            <tr>
                              <th>Sale Date</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Unt Price</th>
                                <th>Total</th>
                            </tr>
                        </thead><tbody>";

            foreach ($sales as $row) {
                $html .= "<tr>
                            <td>{$row['sale_date']}</td>
                            <td>{$row['product_name']} {$row['sku']}</td>
                            <td>{$row['quantity']}</td>
                            <td>{$row['unit_price']}</td>
                            <td>".round($row['quantity'] * $row['unit_price'])."</td>
                        </tr>";
                        
                        
                         $html .="";
                $total += round($row['quantity'] * $row['unit_price']);
                $totalQty += $row['quantity'];
            }

            $html .= "<tfoot>
                <tr>
                    <td colspan='2'></td>
                    <td colspan=''>{$totalQty}</td>
                    <td colspan='2' style='text-align:right; font-weight:bold;'>Total Cost: ".number_format($total,2)."</td>
                </tr>
            </tfoot></tbody></table>";

            $mpdf->WriteHTML($html);

            // Output file
            return $this->response
                ->setHeader('Content-Type', 'application/pdf')
                ->setBody($mpdf->Output('sales_report-'.date('Y-m-d').'.pdf', 'I'));


        //return $this->response->setHeader('Content-Type', 'application/pdf')->setBody($mpdf->Output('sales_report-'.date('Y-m-d').'.pdf', 'I'));
    }

    function purchaseReport() {
        if(!hasPermission('','reports')) {
            return $this->response->setJSON(['success' => false ,'message' => lang('CUstom.permissionDenied')]);
        }
        $fromDate = $this->request->getGet('start');
        $toDate   = $this->request->getGet('end');
        $purchase = $this->purchaseModel->purchaseHistory('','',$fromDate,$toDate,'','p.product_name ASC');

             $mpdf = new Mpdf();
            $header = '
            
            <table width="100%" style="border-bottom: 1px solid #000; font-family: sans-serif; font-size: 12px;">
                <tr>
                    <td width="20%">
                        <img src="'.base_url(getappdata('applogo')).'" width="70"/>
                        <h3>'. getappdata('company_name') .'</h3>
                    </td>
                    <td width="60%" align="center">
                        <h2 style="margin:0;">PURCHASE HISTORY REPORT</h2>
                        <small>From: ' . $fromDate . ' &nbsp; To: ' . $toDate . '</small>
                    </td>
                    <td width="20%" align="right">
                        <small>Generated: ' . date("d-m-Y H:i") . '</small>
                    </td>
                </tr>
            </table>';

            $mpdf->SetHTMLHeader($header, 'O', true); // header only on first page
            $mpdf->DefHTMLHeaderByName('FirstPageHeader', $header);
            $mpdf->DefHTMLHeaderByName('OtherPagesHeader', '');

            $mpdf->SetHTMLHeaderByName('FirstPageHeader');
            $mpdf->SetHTMLHeaderByName('OtherPagesHeader');



            // Body content
            $total = 0;
           
            $html = "<div style='height:50px;padding-top:25px'></div><table  border='1' width='100%' cellspacing='0' cellpadding='5'>
                        <thead>
                            <tr>
                             
                                <th>Purchase Date</th>
                                <th>Product</th>
                                 <th>Quantity</th>
                                 <th>Unit Price</th>
                                <th>Total</th>
                                <th>Supplier</th>
                            </tr>
                        </thead><tbody>";

            foreach ($purchase as $row) {
                $html .= "<tr>
                          
                            <td>{$row['order_date']}</td>
                            <td>{$row['product_name']} {$row['sku']}</td>
                              <td>{$row['quantity']} </td>
                              <td>{$row['price']} </td>
                            <td>".round($row['quantity'] * $row['price'])."</td>
                             <td>{$row['supplier_name']}</td>

                        </tr>";
                        
                        
                         $html .="";
                $total += round($row['quantity'] * $row['price']);
            }

            $html .= "<tfoot>
                <tr>
                    <td colspan='4'></td>
                    <td colspan='1' style='text-align:right; font-weight:bold;'> ".number_format($total,2)."</td>
                    <td></td>
                </tr>
            </tfoot></tbody></table>";

            
            $mpdf->WriteHTML($html);

            // Output file
            return $this->response
                ->setHeader('Content-Type', 'application/pdf')
                ->setBody($mpdf->Output('Purchase-report-'.date('Y-m-d').'.pdf', 'I'));
    }

    function purchaseCustomReport() {
        if(!hasPermission('','reports')) {
            return $this->response->setJSON(['success' => false ,'message' => lang('CUstom.permissionDenied')]);
        }
        $fromDate = $this->request->getGet('start');
        $toDate   = $this->request->getGet('end');
        $purchase = $this->purchaseModel->purchaseHistory('','',$fromDate,$toDate,'','p.product_name ASC');

       //$mpdf = (new MpdfLibrary())->load();
             $mpdf = new Mpdf();
            // Header content (only first page)
            $header = '
            
            <table width="100%" style="border-bottom: 1px solid #000; font-family: sans-serif; font-size: 12px;">
                <tr>
                    <td width="20%">
                        <img src="'.base_url(getappdata('applogo')).'" width="70"/>
                        <h3>'. getappdata('company_name') .'</h3>
                    </td>
                    <td width="60%" align="center">
                        <h2 style="margin:0;">PURCHASE REPORT</h2>
                        <small>From: ' . $fromDate . ' &nbsp; To: ' . $toDate . '</small>
                    </td>
                    <td width="20%" align="right">
                        <small>Generated: ' . date("d-m-Y H:i") . '</small>
                    </td>
                </tr>
            </table>';

           $mpdf->SetHTMLHeader($header, 'O', true); // header only on first page
            $mpdf->DefHTMLHeaderByName('FirstPageHeader', $header);
            $mpdf->DefHTMLHeaderByName('OtherPagesHeader', '');

            $mpdf->SetHTMLHeaderByName('FirstPageHeader');
            $mpdf->SetHTMLHeaderByName('OtherPagesHeader');

            // Body content
            $total = 0;
           
            $html = "<div style='height:50px;padding-top:25px'></div>
            <table style='text-align:left; margin:0 auto; border-collapse:collapse;' border='1' width='60%' cellspacing='0' cellpadding='5'>

                        <thead>
                            <tr>
                                <th>Items</th>
                                <th>Quantity</th>
                            </tr>
                        </thead><tbody>";

            foreach ($purchase as $row) {
                $html .= "<tr>
                            <td>{$row['product_name']}</td>
                              <td>{$row['quantity']} </td>
                            
                        </tr>";
                        
                        
                         $html .="";
                $total += round($row['quantity'] * $row['price']);
            }

            $html .= "<tfoot>
               
            </tfoot></tbody></table>";

            $mpdf->WriteHTML($html);

            // Output file
            return $this->response
                ->setHeader('Content-Type', 'application/pdf')
                ->setBody($mpdf->Output('Purchase-report-'.date('Y-m-d').'.pdf', 'I'));
    }

    function stockReport() {
        if(!hasPermission('','reports')) {
            return $this->response->setJSON(['success' => false ,'message' => lang('CUstom.permissionDenied')]);
        }
        $fromDate = $this->request->getGet('start');
        $toDate   = $this->request->getGet('end');
        $purchase =  $this->productModel->getProductswithAmount('','',1,'',1);
     
        $mpdf = new Mpdf();

        $header = '
            
            <table width="100%" style="border-bottom: 1px solid #000; font-family: sans-serif; font-size: 12px;">
                <tr>
                    <td width="20%">
                        <img src="'.base_url(getappdata('applogo')).'" width="70"/>
                        <h3>'. getappdata('company_name') .'</h3>
                    </td>
                    <td width="60%" align="center">
                        <h2 style="margin:0;">AVAILABLE STOCK REPORT</h2>
                       
                    </td>
                    <td width="20%" align="right">
                        <small>Generated: ' . date("d-m-Y H:i") . '</small>
                    </td>
                </tr>
            </table>';

             $mpdf->SetHTMLHeader($header, 'O', true); // header only on first page
            $mpdf->DefHTMLHeaderByName('FirstPageHeader', $header);
            $mpdf->DefHTMLHeaderByName('OtherPagesHeader', '');

            $mpdf->SetHTMLHeaderByName('FirstPageHeader');
            $mpdf->SetHTMLHeaderByName('OtherPagesHeader');

            // Body content
            $total = 0;
           
            $html = "<div style='height:50px;padding-top:25px'></div>
             <table style='text-align:left; margin:0 auto; border-collapse:collapse;' border='1' width='60%' cellspacing='0' cellpadding='5'>
                        <thead>
                            <tr>
                                <th>Items</th>
                                <th>Quantity</th>
                            </tr>
                        </thead><tbody>";

            foreach ($purchase as $row) {
                $html .= "<tr>
                            <td>{$row['product_name']} </td>
                            <td>{$row['current_stock']} </td>
                        </tr>";
            }
            $html .= "<tfoot>
            </tfoot></tbody></table>";
            $mpdf->WriteHTML($html);
            // Output file
            return $this->response
                ->setHeader('Content-Type', 'application/pdf')
                ->setBody($mpdf->Output('Stock-report-'.date('Y-m-d').'.pdf', 'I'));
    }

    function supllierHistory() {
        if(!hasPermission('','reports')) {
            return $this->response->setJSON(['success' => false ,'message' => lang('CUstom.permissionDenied')]);
        }
        $fromDate = $this->request->getGet('start');
        $toDate   = $this->request->getGet('end');
        $supplierId = $this->request->getGet('cus');
        $paymentStatus = $this->request->getGet('pstatus');
        $paymentType = $this->request->getGet('ptype');
        $result = '';
        if(!empty($supplierId)) {
            $result = $this->supplierModel->getTransactionHistory($supplierId,$fromDate,$toDate,$paymentStatus,$paymentType);
         }
          $mpdf = new Mpdf();

        $header = '
            
            <table width="100%" style="border-bottom: 1px solid #000; font-family: sans-serif; font-size: 12px;">
                <tr>
                    <td width="20%">
                        <img src="'.base_url(getappdata('applogo')).'" width="70"/>
                        <h3>'. getappdata('company_name') .'</h3>
                    </td>
                    <td width="60%" align="center">
                        <h2 style="margin:0;">SUPPLIER HISTORY</h2>
                       <p>From Date : '.$fromDate.' - '.$toDate.'</p>
                       <p>Payment status : '.$paymentStatus.'</p>
                       <p>Payment Type : '.$paymentType.'</p>
                    </td>
                    <td width="20%" align="right">
                        <small>Generated: ' . date("d-m-Y H:i") . '</small>
                    </td>
                </tr>
            </table>';

             $mpdf->SetHTMLHeader($header, 'O', true); // header only on first page
            $mpdf->DefHTMLHeaderByName('FirstPageHeader', $header);
            $mpdf->DefHTMLHeaderByName('OtherPagesHeader', '');

            $mpdf->SetHTMLHeaderByName('FirstPageHeader');
            $mpdf->SetHTMLHeaderByName('OtherPagesHeader');
            $html ='';
            $supplierInfo = $this->supplierModel->where(['id'=>$supplierId])->first();
            //print_r($supplierInfo['store']);exit();
            if(!empty($supplierInfo)) {
                $html .= "<div style='height:50px;padding-top:45px'></div>";
                $html .=' <table width="100%" style="border-bottom: 1px solid #000; font-family: sans-serif; font-size: 12px;">
                    <tr>
                        <td>
                            <p>Store : '.$supplierInfo['store'].'</p>
                        </td>
                    </tr>
                    </table>
                    
                ';
            }

             $total = 0;
           
            $html .= "<div style='height:50px;padding-top:25px'></div>
             <table style='text-align:left; text-transform:capitalize; margin:0 auto; border-collapse:collapse;' border='1' width='90%' cellspacing='0' cellpadding='5'>
                        <thead>
                            <tr>
                                <th>Invoice No</th>
                                <th>Purchase Date</th>
                                <th>Paid Date</th>
                                <th>Payment Status</th>
                                <th>Payment Type</th>
                                <th>Amount</th>
                            </tr>
                        </thead><tbody>";

            foreach ($result as $row) {
                $html .= "<tr>
                            <td>{$row['invoice_number']} </td>
                            <td>{$row['order_date']} </td>
                            <td>{$row['paid_date']} </td>
                             <td>{$row['payment_status']} </td>
                             <td>{$row['payment_type']} </td>
                             <td>{$row['total_amount']} </td>
                        </tr>";
            }
            $html .= "<tfoot>
            </tfoot></tbody></table>";
            $mpdf->WriteHTML($html);
            // Output file
            return $this->response
                ->setHeader('Content-Type', 'application/pdf')
                ->setBody($mpdf->Output('Stock-report-'.date('Y-m-d').'.pdf', 'I'));
            
    }
}