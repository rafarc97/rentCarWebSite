<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <title>Create Ad</title>
</head>
<body>
    
    <div class="container">
    
        <div class="row" style="margin-top: 45px;">
            <div class="col-md-4 col-md-offset-4">
                <h4>Ad Register</h4>
                <hr>
                <form action="{{ route('create.ad') }}" method="post" enctype="multipart/form-data">
                @csrf

                    <div class="results">
                        @if(Session::get('success'))
                            <div class="alert-success alert">
                                {{Session::get('success')}}
                            </div>
                        @endif

                        @if(Session::get('fail'))
                            <div class="alert-danger alert">
                                {{Session::get('fail')}}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="type">Type</label>
                        <select class="form-control" name="type" aria-label="Default select example" value="{{old('type')}}">
                            <option value="car">Car</option>
                            <option value="motorbike">Motorbike</option>
                            <option value="truck">Truck</option>
                        </select>
                        <span class="text-danger">@error('type'){{$message}} @enderror</span>
                    </div>
                    <div class="form-group">
                    <label for="type">Brand</label>
                        <select class="form-control" name="brand" aria-label="Default select example" value="{{old('brand')}}">
                            <option value="audi">Audi</option>
                            <option value="bMW">BMW</option>
                            <option value="mercedes">Mercedes</option>
                            <option value="yamaha">Yamaha</option>
                            <option value="kawasaki">kawasaki</option>
                            <option value="volkswagen">Volkswagen</option>
                        </select>
                        <span class="text-danger">
                            @error('brand'){{$message}} @enderror
                        </span>                    
                    </div>
                    <div class="form-group">
                        <label for="model">Model</label>
                        <input type="text" class="form-control" name="model" placeholder="Enter model" value="{{old('model')}}">
                        <span class="text-danger">
                            @error('model'){{$message}} @enderror
                        </span>                    
                    </div>
                    <div class="form-group">
                        <label for="license_plate">License Plate</label>
                        <input type="date" class="form-control" name="license_plate" value="{{old('license_plate')}}"> 
                        <span class="text-danger">
                            @error('license_plate'){{$message}} @enderror
                        </span>                    
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" class="form-control" name="price" placeholder="Enter price" value="{{old('price')}}">
                        <span class="text-danger">
                            @error('price'){{$message}} @enderror
                        </span>                    
                    </div>
                    <div class="form-group">
                        <label for="color">Color</label>
                        <input type="text" class="form-control" name="color" placeholder="Enter color">
                        <span class="text-danger">
                            @error('color'){{$message}} @enderror
                        </span>                    
                    </div>
                    <div class="form-group">
                        <label for="image">Example file input</label>
                        <input type="file" class="form-control-file" id="image" name="image">
                        <span class="text-danger">
                            @error('password'){{$message}} @enderror
                        </span>                    
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-primary" >   Register Ad
                        </button>
                    </div>
                                    
                </form>
            </div>
        </div>
    </div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
</body>
</html>