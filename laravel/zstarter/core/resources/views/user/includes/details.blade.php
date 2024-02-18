<div class="">
    <div class="card-body">
        <form action="{{ route('panel.update-user-profile', $user->id) }}" method="POST" class="form-horizontal">
            @csrf
            <div class="row">

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name">{{ __('First Name')}}<span class="text-red">*</span></label>
                        <input type="text" placeholder="First Name" class="form-control" name="name" id="name" value="{{ $user->name }}">
                    </div>  
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="lname">{{ __('Last Name')}}<span class="text-red">*</span></label>
                        <input type="text" placeholder="Last Name" class="form-control" name="name" id="lname" value="{{ $user->last_name }}">
                    </div>  
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="email">{{ __('Email')}}<span class="text-red">*</span></label>
                        <input type="email" placeholder="test@test.com" class="form-control" name="email" id="email" value="{{ $user->email }}">
                    </div>  
                </div>
                 
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="phone">{{ __('Phone No')}}</label>
                        <input type="number" placeholder="123 456 7890" id="phone" name="phone" class="form-control" value="{{ $user->phone }}">
                    </div>  
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="dob">{{ __('Date of birth')}}</label>
                        <input class="form-control" type="date" name="dob" placeholder="Select your date" value="{{ $user->dob }}" />
                        <div class="help-block with-errors"></div>
                    </div>  
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">{{ __('Status')}} </label>                                 
                        <select required name="status" class="form-control select2"  >
                            <option value="" readonly>{{ __('Select Status')}}</option>
                            @foreach (getStatus() as $index => $item)
                                <option value="{{ $item['id'] }}" {{ $user->status == $item['id'] ? 'selected' :'' }}>{{ $item['name'] }}</option> 
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="country">{{ __('Country')}}</label>
                        <select name="country" id="country" class="form-control select2">
                            <option value="" readonly>{{ __('Select Country')}}</option>
                            @foreach (\App\Models\Country::all() as  $country)
                                <option value="{{ $country->id }}" @if($user->country != null) {{ $country->id == $user->country ? 'selected' : '' }} @elseif($country->name == 'India') selected @endif>{{ $country->name }}</option>
                            @endforeach
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="state">{{ __('State')}}</label> 
                        <select name="state" id="state" class="form-control select2">
                            @if($user->state != null)
                                <option  required value="{{ $user->state }}" selected>{{ fetchFirst('App\Models\State', $user->state, 'name') }}</option>
                            @endif
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="city">{{ __('City')}}</label>
                        <select name="city" id="city" class="form-control select2">
                            @if($user->city != null)
                                <option required value="{{ $user->city }}" selected>{{ fetchFirst('App\Models\City', $user->city, 'name') }}</option>
                            @endif
                        </select> 
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="pincode">{{ __('Pincode')}}</label>
                        <input id="pincode" type="number" class="form-control" name="pincode" placeholder="Enter Pincode" value="{{ $user->pincode ?? old('pincode') }}" >
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Gender</label>
                        <div class="form-radio">
                                <div class="radio radio-inline">
                                    <label>
                                        <input type="radio" name="gender"  value="Male" {{ $user->gender == 'Male' ? 'checked' : '' }}>
                                        <i class="helper"></i>{{ __('Male')}}
                                    </label>
                                </div>
                                <div class="radio radio-inline">
                                    <label>
                                        <input type="radio" name="gender" value="Female" {{ $user->gender == 'Female' ? 'checked' : '' }}>
                                        <i class="helper"></i>{{ __('Female')}}
                                    </label>
                                </div>
                        </div>                                        
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group" style="margin-top: 20px;">
                        <div class="form-check mx-sm-2">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" name="is_verified" class="custom-control-input" value="1" {{ $user->is_verified == 1 ? 'checked' : '' }}>
                                <span class="custom-control-label">&nbsp; Verified Profile</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group" style="margin-top: 20px;">
                        <div class="form-check mx-sm-2">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" value="{{ now() }}" @if($user->email_verified_at != null)  checked @endif name="email_verified_at">
                                <span class="custom-control-label">&nbsp; Email verified</span>
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="address">{{ __('Address')}}</label>
                        <textarea name="address" name="address" rows="3" class="form-control">{{ $user->address }}</textarea>
                    </div>  
                </div>                                    
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="bio">{{ __('Bio')}}</label>
                        <textarea name="bio" name="bio" rows="3" class="form-control">{{ $user->bio }}</textarea>
                    </div>  
                </div>                                    
            </div>
            
            <button type="submit" class="btn btn-success"  >Update Profile</button>
        </form>
    </div>
</div>