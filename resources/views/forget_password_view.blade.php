@if($errors->any())
    @foreach($errors->all() as $error)
        <p>{{$error}}</p>
    @endforeach
@endif
@if(session()->has('success'))
    <p>{{session()->get('success')}}</p>
@endif
<form action="{{route('update.password')}}" method="post">
    @csrf
    <input name="email" type="hidden" value="{{$email}}">
    <input type="text" name="password"/>
    <input type="text" name="confirmation_password"/>
    <button>Submit</button>
</form>
