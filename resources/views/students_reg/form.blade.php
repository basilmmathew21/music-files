<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Name</label>
        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" type="text" id="name" value="{{ old('name', optional($user)->name) }}" minlength="1" maxlength="255" required="true" placeholder="{{ trans('students.name__placeholder') }}" autofocus>
        @if($errors->has('name'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('name') }}</strong>
        </div>
        @endif
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Gender</label>
        <select name="gender" class="form-control" required="true">
            <option value="" selected disabled>--Choose gender--</option>
            <option value="Male" @if(old('gender')=="Male" ) selected @endif>Male</option>
            <option value="Female" @if(old('gender')=="Female" ) selected @endif>Female</option>
            <option value="Other" @if(old('gender')=="Other" ) selected @endif>Other</option>
        </select>
    </div>
</div>
<div class="row">

    <div class="col-md-6 mb-3">
        <label class="form-label">Address </label>



        <input class="form-control {{ $errors->has('state') ? 'has-error' : '' }}" name="address" type="text" id="name" value="{{ old('address', optional($user)->address) }}" minlength="1" maxlength="255" placeholder="{{ trans('students.address__placeholder') }}">
        @if($errors->has('address'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('address') }}</strong>
        </div>
        @endif


    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">State</label>
        <input class="form-control {{ $errors->has('state') ? 'has-error' : '' }}" name="state" type="text" id="state" value="{{ old('state', optional($user)->state) }}" minlength="1" maxlength="255" placeholder="{{ trans('students.state__placeholder') }}">
        @if($errors->has('state'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('state') }}</strong>
        </div>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Country</label>
        <select name="country" class="form-control" required="true">
            <option value="" selected disabled>--Choose Nation--</option>
            @if(isset($nationalities))
            @foreach ($nationalities as $id => $nation)
            <option value="{{ $id }}" @if(old('country')==$id) selected @endif>{{ $nation }}</option>
            @endforeach
            @endif
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Currency</label>
        <select name="currency" class="form-control" required="true">
            <option value="" selected disabled>--Choose Currency--</option>
            @if(isset($currency))
            @foreach ($currency as $curcy)
            <option value="{{ $curcy['id'] }}" @if(old('currency')==$curcy['id']) selected @endif>{{ $curcy->code }}({{$curcy->symbol}})</option>
            @endforeach
            @endif
        </select>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">DOB</label>
        <input readonly class="form-control datepicker {{ $errors->has('dob') ? 'has-error' : '' }}" name="dob" type="text" id="dob" value="{{ old('dob', optional($user)->dob) }}" minlength="1" maxlength="255" required="true" placeholder="{{ trans('students.dob__placeholder') }}">

        @if($errors->has('dob'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('dob') }}</strong>
        </div>
        @endif
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Phone</label>
        <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" name="phone" id="phone" type="text" value="{{ old('phone', optional($user)->phone) }}" minlength="1" maxlength="255" required="true" placeholder="{{ trans('students.phone__placeholder') }}">

        @if($errors->has('phone'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('phone') }}</strong>
        </div>
        @endif
    </div>

</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Course of interest</label>
        <select name="course" class="form-control" required="true">
            <option value="" selected disabled>--Choose Course--</option>
            @if(isset($courses))
            @foreach ($courses as $id => $course)
            <option value="{{ $id }}" @if(old('course')==$id) selected @endif>{{ $course }}</option>
            @endforeach
            @endif
        </select>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">E-mail</label>
        <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" type="text" id="email" value="{{ old('email', optional($user)->email) }}" minlength="1" maxlength="255" required="true" placeholder="{{ trans('students.email__placeholder') }}">

        @if($errors->has('email'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('email') }}</strong>
        </div>
        @endif
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Password</label>
        <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" type="password" id="password" value="{{ old('password', optional($user)->password) }}" minlength="1" maxlength="255" required="true" placeholder="{{ trans('students.password__placeholder') }}">

        @if($errors->has('password'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('password') }}</strong>
        </div>
        @endif
    </div>
</div>

<!-- <div class="row ">
    <div class="col text-center"><button class="registerbtn">REGISTER</button></div>

</div> -->
<!-- 
<div class="input-group mb-3">

    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" type="text" id="name" value="{{ old('name', optional($user)->name) }}" minlength="1" maxlength="255" required="true" placeholder="{{ trans('students.name__placeholder') }}" autofocus>
    <div class="input-group-append">
        <div class="input-group-text">
            <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
        </div>
    </div>
    @if($errors->has('name'))
    <div class="invalid-feedback">
        <strong>{{ $errors->first('name') }}</strong>
    </div>
    @endif

</div>



<div class="input-group mb-3">
    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" type="text" id="email" value="{{ old('email', optional($user)->email) }}" minlength="1" maxlength="255" required="true" placeholder="{{ trans('students.email__placeholder') }}">
    <div class="input-group-append">
        <div class="input-group-text">
            <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
        </div>
    </div>
    @if($errors->has('email'))
    <div class="invalid-feedback">
        <strong>{{ $errors->first('email') }}</strong>
    </div>
    @endif

</div>


@if(!$user)
<div class="input-group mb-3">
    <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" type="password" id="password" value="{{ old('password', optional($user)->password) }}" minlength="1" maxlength="255" required="true" placeholder="{{ trans('students.password__placeholder') }}">
    <div class="input-group-append">
        <div class="input-group-text">
            <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
        </div>
    </div>
    @if($errors->has('password'))
    <div class="invalid-feedback">
        <strong>{{ $errors->first('password') }}</strong>
    </div>
    @endif
</div>

@endif



<div class="form-group">


    <select name="gender" class="form-control" required="true">
        <option value="" selected disabled>--Choose gender--</option>
        <option value="Male" @if(old('gender')=="Male" ) selected @endif>Male</option>
        <option value="Female" @if(old('gender')=="Female" ) selected @endif>Female</option>
        <option value="Other" @if(old('gender')=="Other" ) selected @endif>Other</option>
    </select>



</div>


<div class="form-group mb-3">
    <input class="form-control datepicker {{ $errors->has('dob') ? 'has-error' : '' }}" name="dob" type="text" id="dob" value="{{ old('dob', optional($user)->dob) }}" minlength="1" maxlength="255" required="true" placeholder="{{ trans('students.dob__placeholder') }}">

    @if($errors->has('dob'))
    <div class="invalid-feedback">
        <strong>{{ $errors->first('dob') }}</strong>
    </div>
    @endif

</div>


<div class="input-group mb-3">

    <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" name="phone" id="phone" type="text" value="{{ old('phone', optional($user)->phone) }}" minlength="1" maxlength="255" required="true" placeholder="{{ trans('students.phone__placeholder') }}">
    <div class="input-group-append">
        <div class="input-group-text">
            <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
        </div>
    </div>
    @if($errors->has('phone'))
    <div class="invalid-feedback">
        <strong>{{ $errors->first('phone') }}</strong>
    </div>
    @endif

</div>

<div class="form-group">

    <select name="course" class="form-control" required="true">
        <option value="" selected disabled>--Choose Course--</option>
        @if(isset($courses))
        @foreach ($courses as $id => $course)
        <option value="{{ $id }}" @if(old('course')==$id) selected @endif>{{ $course }}</option>
        @endforeach
        @endif
    </select>

</div>

<div class="form-group">
    <select name="country" class="form-control" required="true">
        <option value="" selected disabled>--Choose Nation--</option>
        @if(isset($nationalities))
        @foreach ($nationalities as $id => $nation)
        <option value="{{ $id }}" @if(old('country')==$id) selected @endif>{{ $nation }}</option>
        @endforeach
        @endif
    </select>

</div>

<div class="form-group">
    <select name="currency" class="form-control" required="true">
        <option value="" selected disabled>--Choose Currency--</option>
        @if(isset($currency))
        @foreach ($currency as $curcy)
        <option value="{{ $curcy['id'] }}" @if(old('currency')==$curcy['id']) selected @endif>{{ $curcy->code }}({{$curcy->symbol}})</option>
        @endforeach
        @endif
    </select>

</div>


<div class="form-group">
    <input class="form-control {{ $errors->has('state') ? 'has-error' : '' }}" name="state" type="text" id="state" value="{{ old('state', optional($user)->state) }}" minlength="1" maxlength="255" placeholder="{{ trans('students.state__placeholder') }}">
    @if($errors->has('state'))
    <div class="invalid-feedback">
        <strong>{{ $errors->first('state') }}</strong>
    </div>
    @endif

</div>

<div class="form-group">
    <textarea class="form-control {{ $errors->has('state') ? 'has-error' : '' }}" name="address" type="text" id="name" value="{{ old('address', optional($user)->address) }}" minlength="1" maxlength="255" placeholder="{{ trans('students.address__placeholder') }}">{{ old('address', optional($user)->address) }}
    {!! $errors->first('address', '<p class="text-danger">:message</p>') !!}
    </textarea>
    @if($errors->has('address'))
    <div class="invalid-feedback">
        <strong>{{ $errors->first('address') }}</strong>
    </div>
    @endif
</div> -->
