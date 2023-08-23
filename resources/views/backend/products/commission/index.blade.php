@extends('backend.layouts.master')
@section('css')

@endsection
@section('title') @translate(Commissions) @endsection
@section('content')

    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">@translate(Commission list)</h3>
                </div>
                <div class="card-body p-2">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>@translate(S/L)</th>
                            <th>@translate(Amount)</th>
                            <th>@translate(Type)</th>
                            <th>@translate(Action)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($commissions as $commission)
                            <tr>
                                <td> {{ ($loop->index+1) + ($commissions->currentPage() - 1)*$commissions->perPage() }}</td>
                                <td>{{$commission->amount}}</td>
                                <td>{{$commission->type == "percentage" ? "%": ""}}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info btn-flat dropdown-toggle btn-sm"
                                                data-toggle="dropdown" aria-expanded="false">
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu  dropdown-menu-right p-2" role="menu">
                                            <li><a  class="nav-link text-black" onclick="forModal('{{route('commissions.edit', $commission->id)}}','@translate(Commissions update)')"  href="#!">@translate(Edit)</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#!" class="nav-link text-black"
                                                   onclick="confirm_modal('{{ route('commissions.destroy', $commission->id) }}')">@translate(Delete)</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <h3>@translate(No data found)</h3>
                            </tr>
                        @endforelse
                        <div class="float-left">
                            {{ $commissions->links() }}
                        </div>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="col-md-6 col-sm-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">@translate(Commission create)</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-2">
                  <form action="{{route('commissions.store')}}" method="post">
                      @csrf
                      <div class="form-group">
                          <label class="col-form-label">@translate(Amount)</label>
                          <input required value="{{ old('amount') }}" type="number"  class="form-control @error('amount') is-invalid @enderror" step="0.01" min="0" placeholder="@translate(Insert Commission)" name="amount">
                          @error('amount')
                          <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                          @enderror
                      </div>


                      <div class="form-group">
                          <label class="col-form-label">@translate(Select type)</label>
                          <select required class="form-control select2" name="type">
                              <option value="">@translate(Select type)</option>
                              @if(commissionStatus())
                              <option value="percentage">(%) @translate(Percentage)</option>
                              @else
                              <option value="flat">@translate(Flat amount)</option>
                              @endif
                          </select>
                      </div>

                      @if(!commissionStatus())
                          <div class="form-group">
                              <label>@translate(Input the amount start to end for category commission)</label>
                              <div class="row">
                                  <div class="col">
                                      <input type="number" step="0.01" min="0" name="start_amount" class="form-control" placeholder="@translate(Start amount)">
                                  </div>
                                  <div class="col">
                                      <input type="number" step="0.01" min="0" class="form-control" name="end_amount" placeholder="@translate(End amount)">
                                  </div>
                              </div>
                          </div>
                      @endif
                      <button class="btn btn-primary" type="submit">@translate(Save)</button>
                  </form>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('script')
  <script>
      "use strict"
      $(function() {
  var citynames = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
      remote: {
          url: "../getCreditors",
          replace: function(url, query) {
              return url + "?q=" + query;
          },
          ajax : {
              type: "POST",
              data: {
                  q: function() {
                      return $('#tags-input').val()
                  }
              }
          }
      }
  });
  citynames.initialize();

  $('input').tagsinput({
    typeaheadjs: {
      name: 'citynames',
      displayKey: 'name',
      valueKey: 'name',
      source: citynames.ttAdapter()
    }
  });
      });
  </script>
@endsection
