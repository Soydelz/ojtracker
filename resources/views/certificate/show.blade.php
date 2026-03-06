@extends('layouts.app')
@section('title', 'OJT Certificate')
@section('page-title', 'Certificate of Completion')

@section('content')
<div class="space-y-6">

    {{-- Actions bar --}}
    <div class="flex items-center justify-between">
        <p class="text-gray-500 text-sm">Your official OJT Completion Certificate</p>
        <button onclick="downloadCertificate()"
           class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-lg hover:from-indigo-700 hover:to-purple-700 transition shadow-lg cursor-pointer">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            Download as Image
        </button>
    </div>

    {{-- Certificate Preview --}}
    <div class="flex justify-center">
        <div id="certificate-card" style="
            width:100%; max-width:900px;
            background:#fff;
            box-shadow:0 24px 70px rgba(0,0,0,0.22);
            border-radius:6px;
            position:relative;
            font-family:'Georgia',serif;
            overflow:hidden;
            display:flex;
            min-height:580px;
        ">

            {{-- LEFT: content area --}}
            <div style="flex:1; padding:52px 56px; display:flex; flex-direction:column; justify-content:space-between; background:#fff; position:relative; z-index:1;">

                {{-- Watermark --}}
                <div style="
                    position:absolute; top:50%; left:50%;
                    transform:translate(-50%,-50%) rotate(-20deg);
                    font-size:6rem; font-weight:900;
                    color:rgba(22,33,62,0.018);
                    white-space:nowrap; pointer-events:none;
                    letter-spacing:12px; z-index:0;
                    font-family:'Georgia',serif;
                ">OJTRACKER</div>

                {{-- Top: CERTIFICATE heading --}}
                <div>
                    <div style="font-size:2.3rem; letter-spacing:10px; font-weight:900; color:#16213e; text-transform:uppercase; font-family:'Georgia',serif; line-height:1.2;">CERTIFICATE</div>
                    <div style="font-size:0.78rem; letter-spacing:5px; color:#c49a2a; text-transform:uppercase; margin-bottom:22px; margin-top:12px;">of Completion</div>

                    <div style="font-size:0.88rem; color:#888; font-style:italic; margin-bottom:8px;">This is to proudly certify that</div>

                    <div style="font-family:'Dancing Script',cursive; font-size:3.8rem; font-weight:700; color:#16213e; line-height:1.1; margin-bottom:14px;">{{ $user->name }}</div>

                    <p style="font-size:0.88rem; color:#555; line-height:1.85; max-width:460px; margin-bottom:0;">
                        has successfully completed the required On-the-Job Training (OJT) hours
                        @if($user->school)<br>as part of the academic requirements of <strong style="color:#16213e;">{{ $user->school }}</strong>@endif
                    </p>
                </div>

                {{-- Bottom: 2-col grid --}}
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:0 40px; padding-top:32px; align-items:start;">
                    {{-- Col 1 --}}
                    <div style="display:flex; flex-direction:column; gap:18px;">
                        <div>
                            <div style="font-size:0.58rem; letter-spacing:2px; text-transform:uppercase; color:#c49a2a; margin-bottom:4px;">Training Period</div>
                            <div style="font-size:0.82rem; font-weight:700; color:#16213e;">{{ $startDate }} – {{ $endDate }}</div>
                        </div>
                        <div>
                            <div style="font-size:0.58rem; letter-spacing:2px; text-transform:uppercase; color:#c49a2a; margin-bottom:4px;">Date</div>
                            <div style="font-size:0.9rem; font-weight:700; color:#16213e;">{{ $issuedDate }}</div>
                        </div>
                    </div>
                    {{-- Col 2 --}}
                    <div style="display:flex; flex-direction:column; gap:18px;">
                        <div>
                            <div style="font-size:0.58rem; letter-spacing:2px; text-transform:uppercase; color:#c49a2a; margin-bottom:4px;">Hours Rendered</div>
                            <div style="font-size:0.9rem; font-weight:700; color:#16213e;">{{ number_format($user->getTotalRenderedHours(), 2) }} hrs</div>
                        </div>
                        <div style="display:flex; flex-direction:column; align-items:flex-start;">
                            <div style="font-family:'Dancing Script',cursive; font-size:1.7rem; color:#16213e; line-height:1; margin-bottom:8px; width:120px; text-align:center;">Soydelz</div>
                            <div style="width:120px; height:1px; background:#c49a2a;"></div>
                            <div style="font-size:0.6rem; color:#16213e; margin-top:5px; font-weight:600; letter-spacing:0.5px; width:120px; text-align:center;">OJTracker System</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT: dark navy panel --}}
            <div style="width:270px; flex-shrink:0; background:#16213e; position:relative; overflow:hidden;">

                {{-- Gold swoosh circles (top-right) --}}
                <div style="
                    position:absolute; top:-90px; right:-90px;
                    width:300px; height:300px;
                    background:linear-gradient(135deg,#e8a020,#c49a2a);
                    border-radius:50%;
                    opacity:0.95;
                "></div>
                <div style="
                    position:absolute; top:-50px; right:-50px;
                    width:210px; height:210px;
                    background:linear-gradient(135deg,#f5c040,#daa520);
                    border-radius:50%;
                    opacity:0.7;
                "></div>

                {{-- Circular badge (bottom-center) --}}
                <div style="
                    position:absolute; bottom:36px; left:50%; transform:translateX(-50%);
                    width:110px; height:110px;
                    border-radius:50%;
                    background:linear-gradient(135deg,#c49a2a,#f5c040);
                    display:flex; align-items:center; justify-content:center;
                    box-shadow:0 0 0 7px rgba(196,154,42,0.18), 0 0 0 14px rgba(196,154,42,0.09);
                ">
                    <div style="
                        width:88px; height:88px; border-radius:50%;
                        background:#16213e;
                        border:2px solid #c49a2a;
                        display:flex; flex-direction:column; align-items:center; justify-content:center;
                        gap:2px;
                    ">
                        <div style="font-size:1.1rem; font-weight:900; color:#f5c040; letter-spacing:1px; line-height:1;">{{ date('Y') }}</div>
                        <div style="font-size:1.5rem; line-height:1.1;">&#x1F393;</div>
                        <div style="font-size:0.33rem; letter-spacing:2px; text-transform:uppercase; color:#c49a2a; margin-top:1px;">You did it!</div>
                    </div>
                </div>

                {{-- Dashed ring around badge --}}
                <div style="
                    position:absolute; bottom:20px; left:50%; transform:translateX(-50%);
                    width:142px; height:142px;
                    border-radius:50%;
                    border:1px dashed rgba(196,154,42,0.35);
                "></div>

                {{-- Vertical label --}}
                <div style="
                    position:absolute; top:50%; left:50%; transform:translate(-50%,-50%) rotate(-90deg);
                    font-size:0.55rem; letter-spacing:5px; text-transform:uppercase;
                    color:rgba(196,154,42,0.25); white-space:nowrap;
                    margin-top:16px;
                ">OJTracker System</div>

            </div>

        </div>
    </div>



</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
function downloadCertificate() {
    const btn = document.querySelector('button[onclick="downloadCertificate()"]');
    btn.disabled = true;
    btn.textContent = 'Saving...';

    const el = document.getElementById('certificate-card');
    html2canvas(el, {
        scale: 3,
        useCORS: true,
        backgroundColor: '#ffffff',
        logging: false
    }).then(canvas => {
        const link = document.createElement('a');
        link.download = 'OJT_Certificate_{{ str_replace(" ", "_", $user->name) }}.jpg';
        link.href = canvas.toDataURL('image/jpeg', 0.95);
        link.click();
        btn.disabled = false;
        btn.innerHTML = '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>Download as Image';
    });
}
</script>
@endpush
