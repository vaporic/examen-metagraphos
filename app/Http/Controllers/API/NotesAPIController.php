<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateNotesAPIRequest;
use App\Http\Requests\API\UpdateNotesAPIRequest;
use App\Models\Notes;
use App\Repositories\NotesRepository;
use Illuminate\Http\Request;
use InfyOm\Generator\Controller\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class NotesController
 * @package App\Http\Controllers\API
 */

class NotesAPIController extends AppBaseController
{
    /** @var  NotesRepository */
    private $notesRepository;

    public function __construct(NotesRepository $notesRepo)
    {
        $this->notesRepository = $notesRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/notes",
     *      summary="Get a listing of the Notes.",
     *      tags={"Notes"},
     *      description="Get all Notes",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Notes")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $this->notesRepository->pushCriteria(new RequestCriteria($request));
        $this->notesRepository->pushCriteria(new LimitOffsetCriteria($request));
        $notes = $this->notesRepository->all();

        return $this->sendResponse($notes->toArray(), 'Notes retrieved successfully');
    }

    /**
     * @param CreateNotesAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/notes",
     *      summary="Store a newly created Notes in storage",
     *      tags={"Notes"},
     *      description="Store Notes",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Notes that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Notes")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Notes"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateNotesAPIRequest $request)
    {
        $input = $request->all();

        $notes = $this->notesRepository->create($input);

        return $this->sendResponse($notes->toArray(), 'Notes saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/notes/{id}",
     *      summary="Display the specified Notes",
     *      tags={"Notes"},
     *      description="Get Notes",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Notes",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Notes"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var Notes $notes */
        $notes = $this->notesRepository->find($id);

        if (empty($notes)) {
            return Response::json(ResponseUtil::makeError('Notes not found'), 400);
        }

        return $this->sendResponse($notes->toArray(), 'Notes retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateNotesAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/notes/{id}",
     *      summary="Update the specified Notes in storage",
     *      tags={"Notes"},
     *      description="Update Notes",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Notes",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Notes that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Notes")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Notes"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateNotesAPIRequest $request)
    {
        $input = $request->all();

        /** @var Notes $notes */
        $notes = $this->notesRepository->find($id);

        if (empty($notes)) {
            return Response::json(ResponseUtil::makeError('Notes not found'), 400);
        }

        $notes = $this->notesRepository->update($input, $id);

        return $this->sendResponse($notes->toArray(), 'Notes updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/notes/{id}",
     *      summary="Remove the specified Notes from storage",
     *      tags={"Notes"},
     *      description="Delete Notes",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Notes",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var Notes $notes */
        $notes = $this->notesRepository->find($id);

        if (empty($notes)) {
            return Response::json(ResponseUtil::makeError('Notes not found'), 400);
        }

        $notes->delete();

        return $this->sendResponse($id, 'Notes deleted successfully');
    }
}
