@if(view()->exists('Home.index'))
    @include('Home.index')
@elseif(view()->exists('home.index'))
    @include('home.index')
@elseif(view()->exists('home'))
    @include('home')
@endif