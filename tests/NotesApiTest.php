<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NotesApiTest extends TestCase
{
    use MakeNotesTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateNotes()
    {
        $notes = $this->fakeNotesData();
        $this->json('POST', '/api/v1/notes', $notes);

        $this->assertApiResponse($notes);
    }

    /**
     * @test
     */
    public function testReadNotes()
    {
        $notes = $this->makeNotes();
        $this->json('GET', '/api/v1/notes/'.$notes->id);

        $this->assertApiResponse($notes->toArray());
    }

    /**
     * @test
     */
    public function testUpdateNotes()
    {
        $notes = $this->makeNotes();
        $editedNotes = $this->fakeNotesData();

        $this->json('PUT', '/api/v1/notes/'.$notes->id, $editedNotes);

        $this->assertApiResponse($editedNotes);
    }

    /**
     * @test
     */
    public function testDeleteNotes()
    {
        $notes = $this->makeNotes();
        $this->json('DELETE', '/api/v1/notes/'.$notes->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/notes/'.$notes->id);

        $this->assertResponseStatus(404);
    }
}
