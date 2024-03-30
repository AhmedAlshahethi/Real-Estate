@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<div class="page-content">
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
<div class="card">
  <div class="card-body">
        <h6 class="card-title">Property Details</h6>
        <div class="table-responsive">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td>Property Name</td>
                            <th><code>{{$property->property_name}}</code></th>
                        </tr>
                        <tr>
                            <td>Property Status</td>
                            <th><code>{{$property->property_status}}</code></th>
                        </tr>
                        <tr>
                            <td>Lowest Price</td>
                            <th><code>{{$property->lowest_price}}</code></th>
                        </tr>
                        <tr>
                            <td>Max Price</td>
                            <th><code>{{$property->max_price}}</code></th>
                        </tr>
                        <tr>
                            <td>BedRooms</td>
                            <th><code>{{$property->bedrooms}}</code></th>
                        </tr>
                        <tr>
                            <td>Bathrooms</td>
                            <th><code>{{$property->bathrooms}}</code></th>
                        </tr>
                        <tr>
                            <td>Garage</td>
                            <th><code>{{$property->garage}}</code></th>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <th><code>{{$property->address}}</code></th>
                        </tr>
                        <tr>
                            <td>City</td>
                            <th><code>{{$property->city}}</code></th>
                        </tr>
                        <tr>
                            <td>State</td>
                            <th><code>{{$property['pstate']['state_name']}}</code></th>
                        </tr>
                        <tr>
                            <td>Postal Code</td>
                            <th><code>{{$property->postal_code}}</code></th>
                        </tr>
                        <tr>
                            <td>Property Status</td>
                            <th><code>{{$property->property_status}}</code></th>
                        </tr>   
                        <tr>
                            <td>Main Thambnail</td>
                            <th><img src="{{asset($property->property_thambnail)}}" style="width: 100px; height: 70px;"></th>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <th> 
                            @if($property->status == 1)
                               <span class="badge rounded-pill bg-success">Active</span>
                               @else
                               <span class="badge rounded-pill bg-danger">InActive</span>
                             @endif</th>
                        </tr> 
                    </tbody>
                </table>
        </div>
  </div>
</div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
<div class="card">
  <div class="card-body">
        <div class="table-responsive">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td>Property Code</td>
                            <th><code>{{$property->property_code}}</code></th>
                        </tr>
                        <tr>
                            <td>Property Video</td>
                            <th><code>{{$property->property_video}}</code></th>
                        </tr>
                        <tr>
                            <td>Property Size</td>
                            <th><code>{{$property->property_size}}</code></th>
                        </tr>
                        <tr>
                            <td>Neighborhood</td>
                            <th><code>{{$property->neighborhood}}</code></th>
                        </tr>
                        <tr>
                            <td>Latitude</td>
                            <th><code>{{$property->latitude}}</code></th>
                        </tr>
                        <tr>
                            <td>Longitude</td>
                            <th><code>{{$property->longitude}}</code></th>
                        </tr>
                        <tr>
                            <td>Property Type</td>
                            <th><code>{{$property['type']['type_name']}}</code></th>
                        </tr>
                        <tr>
                            <td>Agent</td>
                                @if ($property->agent_id == null)
                                <th><code>Admin</code></th>
                                @else
                                <th><code>{{$property['user']['name']}}</code></th>
                                @endif
                        </tr>
                        <tr>
                            <td>Property Amenities</td>
                            <th>
                                <select name="amenities_id[]" class="js-example-basic-multiple form-select" multiple="multiple" data-width="100%">

                                    @foreach($amenities as $ameni)
                                    <option value="{{ $ameni->amenitis_name }}" {{in_array($ameni->amenitis_name,$amenities_type) ? 'selected' : ''}}>
                                        {{ $ameni->amenitis_name }}</option>
                                    @endforeach
                                </select>
                            </th>
                        </tr>
                    </tbody>
                </table>
                <br><br>
                @if ($property->status == 1)
                  <form method="post" action="{{route('inactive.property')}}">
                    @csrf
                    <input type="hidden" name="id" value="{{$property->id}}">
                    <button type="submit" class="btn btn-danger">InActive</button>
                  </form>
                    @else
                    <form method="post" action="{{route('active.property')}}">
                        @csrf
                        <input type="hidden" name="id" value="{{$property->id}}">
                        <button type="submit" class="btn btn-success">Active</button>
                    </form>

                @endif
        </div>
  </div>
</div>
        </div>
    </div>
</div>


@endsection