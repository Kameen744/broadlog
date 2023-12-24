{{-- <page size="A4" layout="landscape"></page> --}}
    {{-- <div class="row">
        <div class="col-12">
            <h2 class="text-center">{{env('APP_NAME')}}</h2>
        </div>
        <div class="col-12">
            <div class="row d-flex ">
                <div class="ml-1">
                    <p class="p-0 m-0">Medium: name</p>
                    <p class="p-0 m-0">Address: Add</p>
                    <p class="p-0 m-0">Contact: Contac</p>
                </div>
                <div class="">
                    <p class="p-0 m-0">Medium: name</p>
                    <p class="p-0 m-0">Address: Add</p>
                    <p class="p-0 m-0">Contact: Contac</p>
                </div>
                <div class="mr-1">
                    <p class="p-0 m-0">Medium: name</p>
                    <p class="p-0 m-0">Address: Add</p>
                    <p class="p-0 m-0">Contact: Contac</p>
                </div>
            </div>
        </div>
        <div class="col-12">
            <h6>Costing</h6>
            <table class="table table-bordered table-dark table-responsive">
                <thead>
                    <tr class="bg-dark text-white">
                        <th>Specification</th>
                        <th>Spots</th>
                        <th>Rate</th>
                        <th>Rate Total</th>
                        <th>S.C %</th>
                        <th>S.C Amnt</th>
                        <th>V.D %</th>
                        <th>V.D Amnt</th>
                        <th>Agency %</th>
                        <th>Agency Amnt</th>
                        <th>S.P Disc %</th>
                        <th>S.p Discount</th>
                        <th>VAT</th>
                        <th>Gross Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>

                    </tr>
                </tbody>
            </table>
        </div>
    </div> --}}


    @include('reports.header')
<div id="header">INVOICE</div>

<div id="identity">

    <div id="address">
        <p>Chris Coyier</p>
        <p>123 Appleseed Street</p>
            <p>Appleville, WI 53719</p>
                <p>Phone: (555) 555-5555</p>
    </div>

    <div id="logo">

      <div id="logoctr">
        <a href="javascript:;" id="change-logo" title="Change logo">Change Logo</a>
        <a href="javascript:;" id="save-logo" title="Save changes">Save</a>
        |
        <a href="javascript:;" id="delete-logo" title="Delete logo">Delete Logo</a>
        <a href="javascript:;" id="cancel-logo" title="Cancel changes">Cancel</a>
      </div>

      <div id="logohelp">
        <input id="imageloc" type="text" size="50" value="" /><br />
        (max width: 540px, max height: 100px)
      </div>
      <img id="image" class="logo" src="images/logo.png" alt="logo" style="with: 150px; height: 150px;" />
    </div>

</div>

<div style="clear:both"></div>

<div id="customer">

    <div id="customer-title">Widget Corp.c/o Steve Widget</div>

    <table id="meta">
        <tr>
            <td class="meta-head">Invoice #</td>
            <td><textarea>000123</textarea></td>
        </tr>
        <tr>
            <td class="meta-head">Date</td>
            <td><textarea id="date">December 15, 2009</textarea></td>
        </tr>
        <tr>
            <td class="meta-head">Amount Due</td>
            <td><div class="due">$875.00</div></td>
        </tr>

    </table>

</div>

<table id="items">

  <tr>
      <th>Item</th>
      <th>Description</th>
      <th>Unit Cost</th>
      <th>Quantity</th>
      <th>Price</th>
  </tr>

  <tr class="item-row">
      <td class="item-name"><div class="delete-wpr"><textarea>Web Updates</textarea><a class="delete" href="javascript:;" title="Remove row">X</a></div></td>
      <td class="description"><textarea>Monthly web updates for http://widgetcorp.com (Nov. 1 - Nov. 30, 2009)</textarea></td>
      <td><textarea class="cost">$650.00</textarea></td>
      <td><textarea class="qty">1</textarea></td>
      <td><span class="price">$650.00</span></td>
  </tr>

  <tr class="item-row">
      <td class="item-name"><div class="delete-wpr"><textarea>SSL Renewals</textarea><a class="delete" href="javascript:;" title="Remove row">X</a></div></td>

      <td class="description"><textarea>Yearly renewals of SSL certificates on main domain and several subdomains</textarea></td>
      <td><textarea class="cost">$75.00</textarea></td>
      <td><textarea class="qty">3</textarea></td>
      <td><span class="price">$225.00</span></td>
  </tr>

  <tr id="hiderow">
    <td colspan="5"><a id="addrow" href="javascript:;" title="Add a row">Add a row</a></td>
  </tr>

  <tr>
      <td colspan="2" class="blank"> </td>
      <td colspan="2" class="total-line">Subtotal</td>
      <td class="total-value"><div id="subtotal">$875.00</div></td>
  </tr>
  <tr>

      <td colspan="2" class="blank"> </td>
      <td colspan="2" class="total-line">Total</td>
      <td class="total-value"><div id="total">$875.00</div></td>
  </tr>
  <tr>
      <td colspan="2" class="blank"> </td>
      <td colspan="2" class="total-line">Amount Paid</td>

      <td class="total-value"><textarea id="paid">$0.00</textarea></td>
  </tr>
  <tr>
      <td colspan="2" class="blank"> </td>
      <td colspan="2" class="total-line balance">Balance Due</td>
      <td class="total-value balance"><div class="due">$875.00</div></td>
  </tr>

</table>

<div id="terms">
  <h5>Terms</h5>
  <textarea>NET 30 Days. Finance Charge of 1.5% will be made on unpaid balances after 30 days.</textarea>
</div>
@include('reports.footer')

