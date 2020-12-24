<?php

declare(strict_types=1);

namespace Toraido\Fatura;

use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Psl;
use Symfony\Component\HttpFoundation\Response;
use Toraido\Fatura\Model\Invoice;
use Twig\Environment;
use Twig\Error\Error as TwigError;

final class Fatura
{
    public function __construct(
        private Environment $twig,
        private Convertor\Convertor $convertor,
        private Naming\Namer $namer,
    ) {
    }

    /**
     * Render the given `Invoice` instance into an HTML document.
     *
     * @return non-empty-string
     *
     * @throws TwigError If an error accord while rendering the invoice template.
     */
    public function render(Invoice $invoice): string
    {
        $html = $this->twig->render('@ToraidoFatura/display.html.twig', [
            'invoice' => $invoice,
        ]);

        Psl\invariant($html !== '', 'Internal: twig returned an empty string.');

        return $html;
    }

    /**
     * Convert the given `Invoice` instance into a PDF file.
     *
     * @return non-empty-string The PDF file content.
     *
     * @throws TwigError If an error accord while rendering the invoice template.
     */
    public function convert(Invoice $invoice): string
    {
        $html = $this->render($invoice);
        return $this->convertor->convert($html);
    }

    /**
     * Convert the given`Invoice` instance into a PDF file,
     * and return a response that will result in downloading the invoice for the client.
     *
     * @throws TwigError If an error accord while rendering the invoice template.
     */
    public function download(Invoice $invoice): Response
    {
        return new PdfResponse($this->convert($invoice), $this->namer->name($invoice));
    }
}
