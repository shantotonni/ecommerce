<?php
if (! function_exists('title')) {
    function title() {
        if(\Illuminate\Support\Facades\Auth::user()->UserName == "mrinmoy"){return "ACI-Ricebazar";}
        if(\Illuminate\Support\Facades\Auth::user()->UserName == "premio"){return "ACI-Premio Plastic";}
        if(\Illuminate\Support\Facades\Auth::user()->UserName == "ebazar"){return "ACI-Ebazar";}
        if(\Illuminate\Support\Facades\Auth::user()->UserName == "sonalika"){return "ACI-Sonalika";}
        if(\Illuminate\Support\Facades\Auth::user()->UserName == "hygiene"){return "ACI-Hygiene";}
        if(\Illuminate\Support\Facades\Auth::user()->UserName == "aronno"){return "ACI Aronno";}
        if(\Illuminate\Support\Facades\Auth::user()->UserName == "robel"){return "Dashboard";}
        if(\Illuminate\Support\Facades\Auth::user()->UserName == "aciseed"){return "ACI Seed";}
        if(\Illuminate\Support\Facades\Auth::user()->UserName == "alam"){return "ACI Aronno";}
        if(\Illuminate\Support\Facades\Auth::user()->UserName == "abrar"){return "ACI Aronno";}
    }
}
