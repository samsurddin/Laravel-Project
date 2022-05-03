@extends('layouts.admin.app')

@section('breadcrumb-title')
<h3>Orders</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Orders</li>
@endsection
							
@section('content')
	<div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="head position-relative overflow-hidden">
                    <h5>Order List</h5>
                    <div class="float-end">
                        <a href="#" class="btn btn-primary">
                            Refresh List
                        </a>
                        <a href="#" class="btn btn-secondary">
                            Export to Excel
                        </a>
                    </div>
                    {{-- <a href="{{ route('admin.orders.create', app()->getLocale()) }}" class="btn btn-primary float-end">Add New</a> --}}
                </div>

                <x-alert/>
            </div>
            <div class="card-body pt-0">
            	<!-- <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th> {{-- Order Number, Order Date --}}
                                <th scope="col">Customer</th> {{-- Shipping Name, Shipping Number, Shiping City --}}
                                <th scope="col">Amount</th> {{-- Total Amounts, Total subtotal, Total charges --}}
                                <th scope="col">Status</th> {{-- Order status, Payment status --}}
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="data">
                        	@foreach ($orders as $order)
				            @php
                                // dd($order->updated_at);
                                // dd($order->ShippingFullAddress);
                                // $updated = $order->updated_at->diffForHumans();
                                $order = $order->toArray();
                                // dd($order);
				            	// $shop = $product->shop()->get();
				            	// // dd($shop->toSql());
				            	// $categories = $product->categories()->get();
				            	// // dd($shop);
				            	// // dd($categories->toSql());
				            @endphp
                            <tr>
                                <td scope="row">
                                    <p class="fw-bold mb-2">{{ short_order_number($order['order_number']) }}</p>
                                    <p class="text-muted">{{ $order['updated_at'] }}</p>
                                </td>
                                <td>
                                    <p class="fw-bold mb-2">{{ $order['shipping_fullname'] }}</p>
                                    <div class="text-muted">
                                        <small><i data-feather="phone"></i> {{ $order['shipping_mobile'] }}</small><br>
                                        <small><i data-feather="map-pin"></i> {{ $order['shipping_city_name'] }}</small>
                                    </div>
                                    
                                	<a href="{{ route('admin.users.show', [app()->getLocale(), $order['user_id']]) }}" class="d-flex">
                                		User
                                	</a>
                                </td>
                                <td>
                                    <p class="fw-bold mb-2">Total: @money($order['grand_total'])</p>
                                    <div class="text-muted text-sm">
                                        <small>Products: @money($order['sub_total'])</small><br>
                                        <small>Charges: @money($order['total_charges'])</small>
                                    </div>
                                </td>
                                <td>
                                    {{ $order['status'] }} <span class="badge bg-primary">{{ $order['is_paid'] }}</span>
                                </td>
                                <td></td>
                                {{-- <td><a href="{{ $shop->slug }}">{{ $shop->name }}</a></td> --}}
                                <td>
                                    <form method="post" action="{{ route('admin.orders.destroy', [app()->getLocale(), $order['id']]) }}" class="d-inline"> @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-xs delete" type="submit">Delete</button>
                                    </form>
                                    <a href="{{ route('admin.orders.show', [app()->getLocale(), $order['id']]) }}" class="btn btn-success btn-xs edit" title="">View</a>
								</td>
                            </tr>
                        	@endforeach
                        </tbody>
                    </table>
                    <div class="paginage mt-4">
                    	{{ $orders->links() }}
                    </div>
                </div> -->

                <div class="table-responsive">
                    {{-- <div class="table-title">
                        <div class="row">
                            <div class="col-sm-4">
                                <h2>Order <b>Details</b></h2>
                            </div>
                            <div class="col-sm-8">                      
                                <a href="#" class="btn btn-primary"><i class="material-icons">&#xE863;</i> <span>Refresh List</span></a>
                                <a href="#" class="btn btn-secondary"><i class="material-icons">&#xE24D;</i> <span>Export to Excel</span></a>
                            </div>
                        </div>
                    </div> --}}
                    <div class="table-filter o-hidden">
                        <div class="float-end">
                            {{-- <div class="col-sm-3">
                                <div class="show-entries">
                                    <span>Show</span>
                                    <select class="form-select">
                                        <option>20</option>
                                        <option>50</option>
                                        <option>100</option>
                                        <option>200</option>
                                    </select>
                                    <span>items</span>
                                </div>
                            </div> --}}
                            {{-- <div class="col-sm-9"> --}}
                                {{-- <span class="filter-icon"><i class="fa fa-filter"></i></span> --}}
                                <div class="filter-group">
                                    <label>Location</label>
                                    <select class="form-select">
                                        <option>All</option>
                                        <option>Berlin</option>
                                        <option>London</option>
                                        <option>Madrid</option>
                                        <option>New York</option>
                                        <option>Paris</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <label>Status</label>
                                    <select class="form-select">
                                        <option>Any</option>
                                        <option>Delivered</option>
                                        <option>Shipped</option>
                                        <option>Pending</option>
                                        <option>Cancelled</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    {{-- <label>Name</label> --}}
                                    <input type="text" class="form-control" placeholder="Name">
                                </div>
                                <button type="button" class="btn btn-primary"><i class="fa fa-search"></i></button>
                            {{-- </div> --}}
                        </div>
                    </div>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Location</th>
                                <th>Order Date</th>                     
                                <th>Status</th>                     
                                <th>Net Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            @php
                                // dd($order);
                            @endphp
                            <tr>
                                <td>
                                    <a href="{{ route('admin.orders.show', [app()->getLocale(), $order->id]) }}" title="Order #{{ $order->short_order_number }}" data-toggle="tooltip">{{ $order->id }}</a>
                                </td>
                                <td>
                                    <a href="#">
                                        <img src="https://www.tutorialrepublic.com/examples/images/avatar/1.jpg" class="avatar" alt="{{ $order->user->name }}">
                                        {{ $order->user->name }}
                                    </a>
                                </td>
                                <td>
                                    <span>{{ $order->shipping_city_name }}</span><br>
                                    <small class="text-muted">{{ $order->shipping_mobile }}</small>
                                </td>
                                <td>
                                    <span title="{{ $order->updated_at_human }}" data-toggle="tooltip">{{ $order->updated_at }}</span>
                                </td>                        
                                <td><span class="status text-success">&bull;</span> {{ $order->status }}</td>
                                <td>@money($order->grand_total)</td>
                                <td class="action-links">
                                    <a href="{{ route('admin.orders.show', [app()->getLocale(), $order->id]) }}" title="View Details" data-toggle="tooltip">
                                        {{-- <i data-feather="eye"></i> --}}
                                        {{-- <i class="fa fa-caret-right"></i> --}}
                                        <i class="fa fa-chevron-right"></i>
                                    </a>
                                    <a href="#" title="Download Invoice" data-toggle="tooltip">
                                        <i class="fa fa-file-pdf-o"></i>
                                    </a>
                                    <a href="#" title="Print Invoice" data-toggle="tooltip">
                                        <i class="fa fa-print"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td>2</td>
                                <td><a href="#"><img src="https://www.tutorialrepublic.com/examples/images/avatar/2.jpg" class="avatar" alt="Avatar"> Paula Wilson</a></td>
                                <td>Madrid</td>                       
                                <td>Jun 21, 2017</td>
                                <td><span class="status text-info">&bull;</span> Shipped</td>
                                <td>$1,260</td>
                                <td><a href="#" class="view" title="View Details" data-toggle="tooltip"><i class="material-icons">&#xE5C8;</i></a></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td><a href="#"><img src="https://www.tutorialrepublic.com/examples/images/avatar/3.jpg" class="avatar" alt="Avatar"> Antonio Moreno</a></td>
                                <td>Berlin</td>
                                <td>Jul 04, 2017</td>
                                <td><span class="status text-danger">&bull;</span> Cancelled</td>
                                <td>$350</td>
                                <td><a href="#" class="view" title="View Details" data-toggle="tooltip"><i class="material-icons">&#xE5C8;</i></a></td>                        
                            </tr>
                            <tr>
                                <td>4</td>
                                <td><a href="#"><img src="https://www.tutorialrepublic.com/examples/images/avatar/4.jpg" class="avatar" alt="Avatar"> Mary Saveley</a></td>
                                <td>New York</td>
                                <td>Jul 16, 2017</td>                       
                                <td><span class="status text-warning">&bull;</span> Pending</td>
                                <td>$1,572</td>
                                <td><a href="#" class="view" title="View Details" data-toggle="tooltip"><i class="material-icons">&#xE5C8;</i></a></td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td><a href="#"><img src="https://www.tutorialrepublic.com/examples/images/avatar/5.jpg" class="avatar" alt="Avatar"> Martin Sommer</a></td>
                                <td>Paris</td>
                                <td>Aug 04, 2017</td>
                                <td><span class="status text-success">&bull;</span> Delivered</td>
                                <td>$580</td>
                                <td><a href="#" class="view" title="View Details" data-toggle="tooltip"><i class="material-icons">&#xE5C8;</i></a></td>
                            </tr>
                        </tbody>
                    </table>
                    {{-- <div class="clearfix">
                        <div class="hint-text">Showing <b>5</b> out of <b>25</b> entries</div>
                        <ul class="pagination">
                            <li class="page-item disabled"><a href="#">Previous</a></li>
                            <li class="page-item"><a href="#" class="page-link">1</a></li>
                            <li class="page-item"><a href="#" class="page-link">2</a></li>
                            <li class="page-item"><a href="#" class="page-link">3</a></li>
                            <li class="page-item active"><a href="#" class="page-link">4</a></li>
                            <li class="page-item"><a href="#" class="page-link">5</a></li>
                            <li class="page-item"><a href="#" class="page-link">6</a></li>
                            <li class="page-item"><a href="#" class="page-link">7</a></li>
                            <li class="page-item"><a href="#" class="page-link">Next</a></li>
                        </ul>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@stop
                                        