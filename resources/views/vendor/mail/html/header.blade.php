@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            <img src="{{ url('logo/email/logo.png') }}"
                 style="width: 200px; height: auto; display: block;"
                 alt="{{ config('app.name') }}">
        </a>
    </td>
</tr>
