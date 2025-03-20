@if ($paginator->hasPages())
    <ul class="pagination center-align">
        
        @if ($paginator->onFirstPage())
            <li class="disabled">
                <a href="#"><i class="material-icons">chevron_left</i></a>
            </li>
        @else
            <li class="waves-effect">
                <a href="{{ $paginator->previousPageUrl() }}"><i class="material-icons">chevron_left</i></a>
            </li>
        @endif
        
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="disabled"><a href="#">{{ $element }}</a></li>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active brown darken-2"><a href="#" class="white-text">{{ $page }}</a></li>
                    @else
                        <li class="waves-effect"><a href="{{ $url }}" class="brown-text text-darken-2">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <li class="waves-effect">
                <a href="{{ $paginator->nextPageUrl() }}"><i class="material-icons">chevron_right</i></a>
            </li>
        @else
            <li class="disabled">
                <a href="#"><i class="material-icons">chevron_right</i></a>
            </li>
        @endif
    </ul>
@endif

