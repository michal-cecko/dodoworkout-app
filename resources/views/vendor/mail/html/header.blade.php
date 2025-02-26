@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            <!-- Default logo for light mode -->
            <img src="{{ url('logo/logo-black-red.png') }}"
                 style="width: 200px; height: auto; display: block;"
                 class="logo-light"
                 alt="{{ config('app.name') }}">

            <!-- Logo for dark mode -->
            <img src="{{ url('logo/logo-white-red.png') }}"
                 style="width: 200px; height: auto; display: none;"
                 class="logo-dark"
                 alt="{{ config('app.name') }}">
        </a>
    </td>
</tr>

<style>
    /* Hide dark mode logo by default */
    .logo-dark {
        display: none;
    }

    /* Show dark mode logo in dark mode */
    @media (prefers-color-scheme: dark) {
        .logo-light {
            display: none;
        }
        .logo-dark {
            display: block;
        }
    }
</style>
