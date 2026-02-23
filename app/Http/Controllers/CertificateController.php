<?php

namespace App\Http\Controllers;

use App\Http\Requests\Certificate\DownloadCertificateRequest;
use App\Http\Requests\Certificate\GenerateCertificateRequest;
use App\Http\Requests\Certificate\PreviewCertificateRequest;
use App\Models\Course;
use App\Repositories\Interfaces\CertificateRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    protected $certificateRepository;

    public function __construct(CertificateRepositoryInterface $certificateRepository)
    {
        $this->certificateRepository = $certificateRepository;
    }

    /**
     * Preview the certificate before generating it.
     */
    public function preview(PreviewCertificateRequest $request, Course $course)
    {
        $user = $request->user();
        $certificate = $this->certificateRepository->firstOrNew($user, $course);

        return view('certificates.preview', [
            'course' => $course,
            'user' => $user,
            'date' => $certificate->issued_at ?? now(),
            'is_preview' => !$certificate->exists,
        ]);
    }

    /**
     * Generate (save) and show the certificate.
     */
    public function generate(GenerateCertificateRequest $request, Course $course)
    {
        $user = $request->user();
        $certificate = $this->certificateRepository->generate($user, $course);

        return redirect()->route('certificates.show', $certificate->id);
    }

    /**
     * Show a final generated certificate using its UUID.
     */
    public function show(string $id)
    {
        $certificate = $this->certificateRepository->findById($id);

        return view('certificates.preview', [
            'certificate' => $certificate,
            'course' => $certificate->course,
            'user' => $certificate->user,
            'date' => $certificate->issued_at,
            'is_preview' => false,
        ]);
    }

    /**
     * Download the certificate PDF (admin only, language-specific).
     */
    public function downloadAdmin(DownloadCertificateRequest $request, string $id, string $lang)
    {
        app()->setLocale($lang);

        $certificate = $this->certificateRepository->findById($id);

        $html = view('certificates.pdf', [
            'certificate' => $certificate,
            'course' => $certificate->course,
            'user' => $certificate->user,
            'date' => $certificate->issued_at,
        ])->render();

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L',
            'autoScriptToLang' => true,
            'autoLangToFont' => true,
        ]);

        $mpdf->WriteHTML($html);

        return response($mpdf->Output('', 'S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="certificate_' . $certificate->id . '_' . $lang . '.pdf"',
        ]);
    }
}
