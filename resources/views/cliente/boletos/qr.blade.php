<x-cliente-layout>
    <div class="space-y-6">
        <div class="rounded-2xl border border-black/10 bg-white p-6 shadow-sm text-center">
            <h2 class="text-xl font-semibold text-[#12241C]">QR de pago generado</h2>
            <p class="mt-2 text-sm text-[#12241C]/60">Escanea este QR para finalizar el pago de tu reserva.</p>
        </div>

        <div class="rounded-3xl border border-black/10 bg-white p-6 shadow-sm mx-auto max-w-md">
            <img
                src="{{ $qrImage }}"
                alt="QR de pago"
                class="mx-auto w-72 rounded-3xl border border-black/10 bg-white p-4"
            >
            <div class="mt-6 text-left text-sm text-[#12241C]/70 space-y-2">
                <p><strong>Reserva:</strong> #{{ $reserva->id }}</p>
                <p><strong>Cliente:</strong> {{ auth('cliente')->user()->nombre_completo }}</p>
                <p><strong>Boletos:</strong> {{ $reserva->boletos->count() }} / {{ $reserva->cantidad }}</p>
                <p><strong>Teléfono de pago:</strong> 71005452</p>
            </div>


            <div class="mt-6 rounded-2xl border border-black/10 bg-[#F6F3E9] p-4 text-sm text-[#12241C]/70">
                El plazo de pago QR es de <strong>{{ \App\Models\Boleto::TIEMPO_PAGO_QR_MINUTOS }} minutos</strong>. Revisa el vencimiento de cada boleto antes de enviar el comprobante.
            </div>

            <div class="mt-4 space-y-3">
                @foreach($boletos as $boleto)
                    @if($boleto->estado === 'pendiente')
                        <div class="rounded-xl border border-black/10 bg-white p-4 text-sm text-[#12241C]/70">
                            <p class="font-semibold text-[#12241C]">Asiento {{ $boleto->numero_asiento }} · Bs {{ number_format((float) $boleto->precio, 2) }}</p>
                            <x-expiration-countdown :boleto="$boleto" />
                        </div>
                    @endif
                @endforeach
            </div>


            <div class="mt-4 flex flex-col gap-3">
                <a href="https://wa.me/59171005452" target="_blank" class="inline-flex items-center justify-center rounded-full bg-[#25D366] px-4 py-3 text-sm font-semibold text-white hover:brightness-95">
                    Enviar confirmación al WhatsApp +591 71005452
                </a>
                <a href="{{ route('cliente.boletos.index') }}" class="inline-flex items-center justify-center rounded-full bg-[#0B2A1E] px-4 py-3 text-sm font-semibold text-white hover:bg-[#1B6B45]">
                    Ver mis boletos
                </a>
            </div>
        </div>
    </div>
</x-cliente-layout>
