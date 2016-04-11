<?php

namespace App\Repositories;

use App\Models\Notes;
use InfyOm\Generator\Common\BaseRepository;

class NotesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'note'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Notes::class;
    }
}
