<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Certificate\GenerateCertificateRequest;
use App\Http\Requests\Certificate\PreviewCertificateRequest;
use App\Http\Resources\CertificateResource;
use App\Models\Course;
use App\Repositories\Interfaces\CertificateRepositoryInterface;

class CertificateController extends Controller
{
    protected $certificateRepository;

    public function __construct(CertificateRepositoryInterface $certificateRepository)
    {
        $this->certificateRepository = $certificateRepository;
    }

    /**
     * Get a user's certificates
     */
    public function index(\Illuminate\Http\Request $request)
    {
        $user = auth()->user();
        $perPage = $request->query('per_page', 10);
        $certificates = $this->certificateRepository->getUserCertificates($user, (int)$perPage);
        
        return $this->successResponse(CertificateResource::collection($certificates)->response()->getData(true));
    }

    /**
     * Preview (check if user can generate) before generating
     */
    public function preview(PreviewCertificateRequest $request, Course $course)
    {
        $user = $request->user();
        $certificate = $this->certificateRepository->firstOrNew($user, $course);

        return $this->successResponse([
            'certificate' => new CertificateResource($certificate),
            'is_preview' => !$certificate->exists,
        ], __('messages.eligible_certificate'));
    }

    /**
     * Generate the certificate.
     */
    public function generate(GenerateCertificateRequest $request, Course $course)
    {
        $user = $request->user();
        $certificate = $this->certificateRepository->generate($user, $course);
        $certificate->load(['course', 'user']);

        return $this->successResponse(new CertificateResource($certificate), __('messages.certificate_generated'), 201);
    }

    /**
     * Show a final generated certificate using its UUID
     */
    public function show(string $id)
    {
        $certificate = $this->certificateRepository->findById($id);

        return new CertificateResource($certificate);
    }
}
