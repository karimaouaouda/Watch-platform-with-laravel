<?php

namespace App\Livewire\Movies;

use App\Models\Movie;
use Livewire\Component;

class Watch extends Component
{

    public Movie $film;

    public function render()
    {
        return view('livewire.movies.watch', [
            'film' => $this->film
        ]);
    }
}
