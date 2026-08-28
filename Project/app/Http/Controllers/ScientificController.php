<?php

namespace App\Http\Controllers;

class ScientificController extends Controller
{
    public function researchInternational() {
        return view('scientific.research-international');
    }

    public function articlesInternational() {
        return view('scientific.articles-international');
    }

    public function rnd() {
        return view('scientific.rnd');
    }

    public function submitProposal() {
        return view('scientific.submit-proposal');
    }
}