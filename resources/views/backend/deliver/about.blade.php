
    @if($user->pic != null)
        <img class="card-img-top" src="{{filePath($user->pic)}}" alt="Card image cap">
    @endif
    <div class="card-body">
        <h5 class="card-title">
            <p> @translate(First Name) : <span class="text-info">  {{$user->first_name}}</span></p>
            <p> @translate(Last Name) : <span class="text-info">  {{$user->last_name}}</span></p>
            <p>@translate(Email) : <span class="text-info">  {{$user->email}}</span></p>
            <p>@translate(Gender) : <span class="text-info">  {{$user->gender}}</span></p>
            <p>@translate(Phone number) : <span class="text-info">  {{$user->phone_num}}</span></p>
            <p><a target="_blank" href="{{filePath($user->document)}}">@translate(See Document)</a></p>
        </h5>
        <p class="card-text">@translate(Permanent Address) : {{$user->permanent_address}}.</p>
        <p class="card-text">@translate(Present Address) : {{$user->present_address}}.</p>
    </div>






