<div class="table-responsive mb-3" style="padding-bottom: 0.4rem;">
  @if($classifieds->isEmpty())
    <div class="text-center py-4 rounded" style="border:1px dashed rgba(255,140,0,0.2);">
      <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="1.5" class="mb-2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
      <h6 class="fw-bold mb-1" style="font-size:0.9rem;">{{ __('No classifieds found.') }}</h6>
      <p class="text-secondary mb-0" style="font-size:0.78rem;">{{ __('When you post a classified, it will appear here.') }}</p>
    </div>
  @else
    <table class="table table-borderless align-middle mb-0" style="background: transparent !important; color: inherit !important;">
      <thead>
        <tr style="border-bottom: 1.5px solid rgba(255,140,0,0.25); background: transparent !important;">
          <th class="text-uppercase text-secondary fw-bold py-2" style="font-size:0.72rem; letter-spacing:1px; background: transparent !important; color: inherit !important;">Date</th>
          <th class="text-uppercase text-secondary fw-bold py-2" style="font-size:0.72rem; letter-spacing:1px; background: transparent !important; color: inherit !important;">Title</th>
          <th class="text-uppercase text-secondary fw-bold py-2" style="font-size:0.72rem; letter-spacing:1px; background: transparent !important; color: inherit !important;">Amount</th>
          <th class="text-uppercase text-secondary fw-bold py-2 text-center" style="font-size:0.72rem; letter-spacing:1px; background: transparent !important; color: inherit !important;">Post Status</th>
          <th class="text-uppercase text-secondary fw-bold py-2" style="font-size:0.72rem; letter-spacing:1px; background: transparent !important; color: inherit !important;">Payment Gateway</th>
          <th class="text-uppercase text-secondary fw-bold py-2 text-center" style="font-size:0.72rem; letter-spacing:1px; background: transparent !important; color: inherit !important;">Payment Status</th>
          <th class="text-uppercase text-secondary fw-bold py-2 text-end" style="font-size:0.72rem; letter-spacing:1px; background: transparent !important; color: inherit !important;">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($classifieds as $c)
          <tr style="border-bottom: 1px solid rgba(255,140,0,0.08); background: transparent !important;">
            <td class="py-2 text-nowrap" style="background: transparent !important; color: inherit !important;">
              <div class="fw-bold" style="font-size:0.85rem;">{{ $c->created_at->format('M d, Y') }}</div>
            </td>
            <td class="py-2" style="background: transparent !important; color: inherit !important;">
              <div class="fw-bold" style="font-size:0.85rem;">{{ $c->title }}</div>
            </td>
            <td class="py-2 fw-bold" style="background: transparent !important; color: inherit !important; font-size:0.95rem;">
              KSh {{ number_format($c->amount, 2) }}
            </td>
            <td class="py-2 text-center" style="background: transparent !important;">
              @if($c->status === 'approved')
                <span class="fw-bold" style="color:#28a745; font-size:0.8rem;">Approved</span>
              @elseif($c->status === 'rejected')
                <span class="fw-bold" style="color:#ff4d4d; font-size:0.8rem;">Rejected</span>
              @else
                <span class="fw-bold" style="color:orange; font-size:0.8rem;">Pending</span>
              @endif
            </td>
            <td class="py-2 text-secondary" style="background: transparent !important; font-size:0.8rem;">
              {{ $c->payment_status === 'paid' ? 'Wallet/M-Pesa' : 'N/A' }}
            </td>
            <td class="py-2 text-center" style="background: transparent !important;">
              @if($c->payment_status === 'paid')
                <span class="fw-bold" style="color:#28a745; font-size:0.8rem;">Paid</span>
              @else
                <span class="fw-bold" style="color:orange; font-size:0.8rem;">Pending</span>
              @endif
            </td>
            <td class="py-2 text-end" style="background: transparent !important;">
              @if($c->payment_status === 'paid')
                <a href="{{ route('classifieds.show', $c->id) }}" class="btn btn-sm btn-orange py-1 px-2.5" style="font-size:0.75rem;">View</a>
              @else
                <span class="text-secondary" style="font-size:0.78rem;">Awaiting payment</span>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
</div>

@if($classifieds->hasPages())
  <div class="d-flex justify-content-center pt-2 mt-3">
    {{ $classifieds->fragment('tab-classifieds')->links('pagination::bootstrap-5') }}
  </div>
@endif
