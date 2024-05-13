<?php

namespace App\Http\Controllers\SuccessfulEmails;

use App\Actions\SuccessfulEmails\CreateSuccessfulEmailAction;
use App\Actions\SuccessfulEmails\DeleteSuccessfulEmailAction;
use App\Actions\SuccessfulEmails\UpdateSuccessfulEmailAction;
use App\Exceptions\HttpJsonResponseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\SuccessfulEmails\CreateSuccessfulEmailRequest;
use App\Http\Requests\SuccessfulEmails\UpdateSuccessfulEmailRequest;
use App\Http\Resources\SuccessfulEmails\SuccessfulEmailResource;
use App\Repositories\SuccessfulEmails\SuccessfulRepositoryInterface;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class SuccessfulEmailResourceController extends Controller
{
    public function index(SuccessfulRepositoryInterface $repository)
    {
        try{
            $successfulEmails = $repository->get();

            return SuccessfulEmailResource::collection($successfulEmails);

        } catch(HttpJsonResponseException $exception){
            return $this->httpErrorResponse($exception);
        } catch(Exception $exception) {
            return $this->serverErrorResponse($exception);
        }
    }

    public function show(
        int $id, 
        SuccessfulRepositoryInterface $repository
    ){
        try{
            $successfulEmail = $repository->find($id);

            if (!$successfulEmail) {
                throw new HttpJsonResponseException(
                    Response::HTTP_BAD_REQUEST,
                    'recordNotFound',
                    'Record not found',
                );
            }

            return new SuccessfulEmailResource($successfulEmail);
        } catch(HttpJsonResponseException $exception){
            return $this->httpErrorResponse($exception);
        } catch(Exception $exception) {
            return $this->serverErrorResponse($exception);
        }

    }

    public function store(
        CreateSuccessfulEmailRequest $request,
        CreateSuccessfulEmailAction $action,
    ): SuccessfulEmailResource {
        DB::beginTransaction();
        try{

            $successfulEmail = $action->execute($request);

            DB::commit();

            return new SuccessfulEmailResource($successfulEmail);
        } catch(HttpJsonResponseException $exception){
            DB::rollBack();
            return $this->httpErrorResponse($exception);
        } catch(Exception $exception) {
            DB::rollBack();
            return $this->serverErrorResponse($exception);
        }
    }

    public function update(
        UpdateSuccessfulEmailRequest $request,
        SuccessfulRepositoryInterface $repository,
        UpdateSuccessfulEmailAction $action,
    ): SuccessfulEmailResource {
        DB::beginTransaction();
        try{
            $successfulEmail = $repository->find($request->id);

            if (!$successfulEmail) {
                throw new HttpJsonResponseException(
                    Response::HTTP_BAD_REQUEST,
                    'recordNotFound',
                    'Record not found',
                );
            }

            $successfulEmail = $action->execute($request, $successfulEmail);

            DB::commit();

            return new SuccessfulEmailResource($successfulEmail);
        } catch(HttpJsonResponseException $exception){
            DB::rollBack();
            return $this->httpErrorResponse($exception);
        } catch(Exception $exception) {
            DB::rollBack();
            return $this->serverErrorResponse($exception);
        }
    }

    public function delete(
        int $id,
        SuccessfulRepositoryInterface $repository,
        DeleteSuccessfulEmailAction $action,
    ){
        DB::beginTransaction();
        try{
            $successfulEmail = $repository->find($id);

            if (!$successfulEmail) {
                throw new HttpJsonResponseException(
                    Response::HTTP_BAD_REQUEST,
                    'recordNotFound',
                    'Record not found',
                );
            }

            $action->execute($successfulEmail);

            DB::commit();
            
            return $this->successResponse(
                Response::HTTP_OK,
                'Record deleted successfully.'
            );

        } catch(HttpJsonResponseException $exception){
            DB::rollBack();
            return $this->httpErrorResponse($exception);
        } catch(Exception $exception) {
            DB::rollBack();
            return $this->serverErrorResponse($exception);
        }
    }
}
