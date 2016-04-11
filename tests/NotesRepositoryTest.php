<?php

use App\Models\Notes;
use App\Repositories\NotesRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NotesRepositoryTest extends TestCase
{
    use MakeNotesTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var NotesRepository
     */
    protected $notesRepo;

    public function setUp()
    {
        parent::setUp();
        $this->notesRepo = App::make(NotesRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateNotes()
    {
        $notes = $this->fakeNotesData();
        $createdNotes = $this->notesRepo->create($notes);
        $createdNotes = $createdNotes->toArray();
        $this->assertArrayHasKey('id', $createdNotes);
        $this->assertNotNull($createdNotes['id'], 'Created Notes must have id specified');
        $this->assertNotNull(Notes::find($createdNotes['id']), 'Notes with given id must be in DB');
        $this->assertModelData($notes, $createdNotes);
    }

    /**
     * @test read
     */
    public function testReadNotes()
    {
        $notes = $this->makeNotes();
        $dbNotes = $this->notesRepo->find($notes->id);
        $dbNotes = $dbNotes->toArray();
        $this->assertModelData($notes->toArray(), $dbNotes);
    }

    /**
     * @test update
     */
    public function testUpdateNotes()
    {
        $notes = $this->makeNotes();
        $fakeNotes = $this->fakeNotesData();
        $updatedNotes = $this->notesRepo->update($fakeNotes, $notes->id);
        $this->assertModelData($fakeNotes, $updatedNotes->toArray());
        $dbNotes = $this->notesRepo->find($notes->id);
        $this->assertModelData($fakeNotes, $dbNotes->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteNotes()
    {
        $notes = $this->makeNotes();
        $resp = $this->notesRepo->delete($notes->id);
        $this->assertTrue($resp);
        $this->assertNull(Notes::find($notes->id), 'Notes should not exist in DB');
    }
}
