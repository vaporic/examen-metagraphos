<?php

use Faker\Factory as Faker;
use App\Models\Notes;
use App\Repositories\NotesRepository;

trait MakeNotesTrait
{
    /**
     * Create fake instance of Notes and save it in database
     *
     * @param array $notesFields
     * @return Notes
     */
    public function makeNotes($notesFields = [])
    {
        /** @var NotesRepository $notesRepo */
        $notesRepo = App::make(NotesRepository::class);
        $theme = $this->fakeNotesData($notesFields);
        return $notesRepo->create($theme);
    }

    /**
     * Get fake instance of Notes
     *
     * @param array $notesFields
     * @return Notes
     */
    public function fakeNotes($notesFields = [])
    {
        return new Notes($this->fakeNotesData($notesFields));
    }

    /**
     * Get fake data of Notes
     *
     * @param array $postFields
     * @return array
     */
    public function fakeNotesData($notesFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'note' => $fake->text,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $notesFields);
    }
}
