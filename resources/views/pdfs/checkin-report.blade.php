<div>
      <h5>Quantidade de dias reservados:</h5> <span>{{ $data->quantity_days ?? '' }}</span>
      <h6>Método de pagamento:</h6> <span>{{ $data->payment_method ?? '' }}</span>
      <h6>Total pago:</h6> <span>{{ $data->total_amount ?? 0 }}</span>
      <h6>OBS:</h6> <span>{{ $data->notes ?? '' }}</span>
      <h6>Data de checkin:</h6> <span>{{ $data->created_at ?? '' }}</span>
</div>

