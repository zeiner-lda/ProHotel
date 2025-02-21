<x-layout.app>

    <div wire:ignore.self class="modal fade" id="ordered-items" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Itens pedidos</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <table class='table table-hover'>
                <thead class='text-center'>
                   <tr>
                    <th>Foto</th>
                    <th>Pedido</th>
                    <th>Total</th>
                    <th>Quantidade</th>
                    <th>Opção</th>
                   </tr>
                </thead>
                <tbody class='text-center'>
                  @if (isset($orderedItems) && $orderedItems->count() > 0)  
                    @foreach ($orderedItems as $item)
                    <tr>                       
                      
                        <td>
                            <img style="width:50px; height:40px;" src='{{asset("/storage/img/".$item->order_photo)}}'  class='img-fluid rounded' />
                        </td>
                        <td>{{$item->order_name}}</td>
                        <td>{{number_format($item->order_price, 2, ',', ',') ?? 0}} Kz</td>                   
                        <td>{{$item->order_quantity}}</td>
                        <td>
                            <button wire:click='deleteItem({{$item->id}})' class='btn btn-sm btn-danger text-capitalize'>
                                <i class='fa fa-solid fa-times'></i>
                                Remover
                            </button>
                        </td>
                    </tr>
                    @endforeach
                    @else  
                    <td colspan='10'>
                        <div class='alert alert-warning text-center'>Nenhum resultado encontrado!</div>
                    </td>   
                    @endif               
                </tbody>
            </table>
            <div class="{{ $orderedItems->count() < 1 ? 'd-none' : ''}}  ">
                <Button wire:click='finishOrder' class='btn btn-primary btn-sm text-uppercase rounded'>Finalizar pedido</Button>
                <Button data-bs-dismiss="modal" class='btn btn-sm btn-dark text-uppercase rounded'>Fechar</Button>                
            </div>
       
        </div>
        </div>
    </div>
</x-layout.app>


