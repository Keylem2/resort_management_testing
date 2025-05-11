@isset($header)
<tr>
    <td class="header" align="center">
        <a href="{{ config('app.url') }}" style="display: inline-block;">
            @if(file_exists(public_path('images/logo.png')))
                <img src="{{ asset('images/logo.png') }}" 
                     alt="Blue Belle Resort"
                     width="200"
                     style="height: auto; display: block;">
            @else
                <span style="font-family: 'Playfair Display', serif; font-size: 24px; color: #f59e0b;">
                    Blue Belle Resort
                </span>
            @endif
        </a>
    </td>
</tr>
@endisset