@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Products</h3>

    <!-- show create button only for admin -->
    @if(auth()->user()->role === 'admin')
    <button id="btnCreate" class="btn btn-primary mb-3">Create Product</button>
    @endif

    <div id="alert" style="display:none;" class="alert"></div>

    <table class="table" id="productsTable">
        <thead>
            <tr><th>ID</th><th>Name</th><th>Price</th><th>Actions</th></tr>
        </thead>
        <tbody>
            <!-- initial rows from server-side render -->
            @foreach($products as $p)
            <tr data-id="{{ $p->id }}">
                <td>{{ $p->id }}</td>
                <td class="p-name">{{ $p->name }}</td>
                <td class="p-price">{{ $p->price }}</td>
                <td>
                    <button class="btn btn-sm btn-info btn-view">View</button>
                    @if(auth()->user()->role === 'admin')
                        <button class="btn btn-sm btn-warning btn-edit">Edit</button>
                        <button class="btn btn-sm btn-danger btn-delete">Delete</button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination links -->
    {{ $products->links() }}

    <!-- Modal (Bootstrap) -->
    <div class="modal fade" id="productModal" tabindex="-1">
      <div class="modal-dialog">
        <form id="productForm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 id="modalTitle" class="modal-title">Create Product</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
              @csrf
              <input type="hidden" name="_method" id="formMethod" value="POST">
              <input type="hidden" name="product_id" id="product_id">
              <div class="mb-3">
                  <label>Name</label>
                  <input type="text" name="name" id="name" class="form-control"/>
              </div>
              <div class="mb-3">
                  <label>Description</label>
                  <textarea name="description" id="description" class="form-control"></textarea>
              </div>
              <div class="mb-3">
                  <label>Price</label>
                  <input type="number" step="0.01" name="price" id="price" class="form-control"/>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button id="saveBtn" type="submit" class="btn btn-primary">Save</button>
          </div>
        </div>
        </form>
      </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function(){

    // prepare CSRF token for AJAX
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // Open create modal
    $('#btnCreate').click(function(){
        $('#modalTitle').text('Create Product');
        $('#productForm')[0].reset();
        $('#formMethod').val('POST');
        $('#product_id').val('');
        $('#productModal').modal('show');
    });

    // Submit create/update
    $('#productForm').submit(function(e){
        e.preventDefault();
        let method = $('#formMethod').val();
        let id = $('#product_id').val();
        let url = method === 'POST' ? "{{ url('products') }}" : "{{ url('products') }}/" + id;
        let type = method === 'POST' ? 'POST' : 'PUT';
        $.ajax({
            url: url,
            method: type,
            data: $(this).serialize(),
            success: function(res){
                showAlert('success', res.message || 'Saved');
                $('#productModal').modal('hide');
                // refresh table row or append new row
                if(type === 'POST'){
                    prependRow(res.product);
                } else {
                    updateRow(res.product);
                }
            },
            error: function(xhr){
                let msg = 'Error';
                if(xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                showAlert('danger', msg);
            }
        });
    });

    // Edit click
    $(document).on('click', '.btn-edit', function(){
        let tr = $(this).closest('tr');
        let id = tr.data('id');
        $.get("{{ url('products') }}/" + id, function(res){
            $('#modalTitle').text('Edit Product');
            $('#formMethod').val('PUT');
            $('#product_id').val(res.id);
            $('#name').val(res.name);
            $('#description').val(res.description);
            $('#price').val(res.price);
            $('#productModal').modal('show');
        });
    });

    // View click
    $(document).on('click', '.btn-view', function(){
        let tr = $(this).closest('tr');
        let id = tr.data('id');
        $.get("{{ url('products') }}/" + id, function(res){
            alert('Name: '+res.name + '\nPrice: '+res.price + '\nDesc: '+(res.description||'-'));
        });
    });

    // Delete click
    $(document).on('click', '.btn-delete', function(){
        if(!confirm('Delete product?')) return;
        let tr = $(this).closest('tr');
        let id = tr.data('id');
        $.ajax({
            url: "{{ url('products') }}/" + id,
            method: 'DELETE',
            success: function(res){
                showAlert('success', res.message);
                tr.remove();
            },
            error: function(xhr){
                showAlert('danger', xhr.responseJSON?.message || 'Error deleting');
            }
        });
    });

    function showAlert(type, text){
        $('#alert').removeClass().addClass('alert alert-'+type).text(text).show().delay(2500).fadeOut();
    }

    function prependRow(p){
        let row = `<tr data-id="${p.id}">
            <td>${p.id}</td>
            <td class="p-name">${p.name}</td>
            <td class="p-price">${p.price}</td>
            <td>
                <button class="btn btn-sm btn-info btn-view">View</button>
                @if(auth()->user()->role === 'admin')
                <button class="btn btn-sm btn-warning btn-edit">Edit</button>
                <button class="btn btn-sm btn-danger btn-delete">Delete</button>
                @endif
            </td>
        </tr>`;
        $('#productsTable tbody').prepend(row);
    }

    function updateRow(p){
        let tr = $('#productsTable tbody').find('tr[data-id="'+p.id+'"]');
        tr.find('.p-name').text(p.name);
        tr.find('.p-price').text(p.price);
    }

});
</script>
@endsection
