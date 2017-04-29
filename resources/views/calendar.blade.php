@foreach($months as $month)
   @include ('component.month',['month' => $month])
@endforeach
