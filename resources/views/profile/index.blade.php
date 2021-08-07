@extends('layouts.app')

@section('title', 'الملف الشخصي')

@section('content')
  <div class="row">
    <div class="col-md-6 mx-auto">
      <div class="card">
        <div class="text-center">
          <img src="{{ asset('storage/' . auth()->user()->image) }}" alt="" height="82px" width="82px">
          <h3> {{ auth()->user()->name }} </h3>
        </div>

        <div class="card-body text-right p-4">
          <form action="/profile" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="form-group mt-2">
              <label for="name">الاسم</label>
              <input type="text" name="name" id="name" class="form-control" value="{{auth()->user()->name}}">
              @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="email">البريد الإلكتروني</label>
              <input type="text" name="email" id="email" class="form-control" value="{{auth()->user()->email}}">
              @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="password">كلمة المرور</label>
              <input type="password" name="password" id="password" class="form-control">
              @error('password')
                <div class="alert alert-danger"><small>{{ $message }}</small></div>
              @enderror
            </div>

            <div class="form-group">
              <label for="password_confirmation"> إعادة كلمة المرور</label>
              <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
              @error('password_confirmation')
                <div class="alert alert-danger"><small>{{ $message }}</small></div>
              @enderror
            </div>

            <div class="form-group">
              <label for="image">تغيير الصورة الشخصية</label>
              <div class="custom-file">
                <input type="file" name="image" id="image" class="custom-file-input">
                <label for="image" id="image-label" class="custom-file-label text-left" data-browse="استعرض"></label>
              </div>
              @error('image')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group d-flex mt-5 flex-row-reverse">
              <button type="submit" class="btn btn-primary mr-2">حفظ التعديلات</button>   
              <button type="submit" class="btn btn-light" form="logout">تسجيل خروج</button>   
            </div>

          </form>

          <form action="/logout" method="POST" id="logout">
            @csrf
          </form>
        </div>
      </div>
    </div>
  </div>    

  <script>
    document.getElementById('image').onchange = uploadOnChange;

    function uploadOnChange () {
      let fileName = this.value;
      let lastIndex = fileName.lastIndexOf("\\");

      if (lastIndex >= 0) {
        fileName = fileName.substring(lastIndex + 1);
      }

      document.getElementById('image-label').innerHTML = fileName;
    }
  </script>
@endsection