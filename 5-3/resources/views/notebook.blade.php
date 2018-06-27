@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-xs-8 col-xs-offset-2 panel panel-default">
            <div class="row text-center">
                <h4><a class="glyphicon glyphicon-refresh" href='{{ route('contacts.index') }}'></a>
                    @if (!empty($operationResult))
                        <span>{{ $operationResult }}</span>
                    @endif
                    @if (count($errors) > 0)
                        <div class="errors">
                            <ul class="list-group">
                                @foreach ($errors->all() as $error)
                                    <li class="list-group-item">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </h4>
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form-inline" role="form" action="{{ route('contacts.index') }}" method="POST">
                        <div class="row text-center">
                            <span class="glyphicon glyphicon-search"></span>
                            {{ csrf_field() }}
                            <input class="form-control" type="text" name="f_first_name"
                                   value="{{ $f_first_name or '' }}" placeholder="Name">
                            <input class="form-control" type="text" name="f_last_name" value="{{ $f_last_name or '' }}"
                                   placeholder="Last name">
                            <input class="form-control" type="tel" name="f_phone_number"
                                   value="{{ $f_phone_number or '' }}" placeholder="79999999999">
                            <input class="btn btn-default" type="submit" name="find" value="Search">
                        </div>
                    </form>
                </div>
                @if (!empty($editContactID))
                    <div class="panel-body">
                        <form class="form-inline" role="form"
                              action="{{ route('contacts.update', ['id' => $editContactID]) }}" method="POST">
                            <div class="row text-center">
                                <span class="glyphicon glyphicon-pencil"></span>
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                @foreach ($contacts as $contact)
                                    @if ($contact->id == $editContactID)
                                        <input class="form-control" type="text" name="first_name"
                                               value="{{ $contact->first_name }}">
                                        <input class="form-control" type="text" name="last_name"
                                               value="{{ $contact->last_name }}">
                                        <input class="form-control" type="tel" name="phone_number"
                                               value="{{ $contact->phone_number }}">
                                        <input type="hidden" name="editContactID" value="{{ $contact->id }}">
                                        <input class="btn btn-default" type="submit" name="save" value="Update">
                                    @endif
                                @endforeach
                            </div>
                        </form>
                    </div>
                @else
                    <div class="panel-body">
                        <form class="form-inline" role="form" action="{{ route('contacts.index') }}" method="POST">
                            <div class="row text-center">
                                <span class="glyphicon glyphicon-plus"></span>
                                {{ csrf_field() }}
                                <input class="form-control" type="text" name="first_name" value="" placeholder="Name">
                                <input class="form-control" type="text" name="last_name" value=""
                                       placeholder="Last name">
                                <input class="form-control" type="tel" name="phone_number" value=""
                                       placeholder="79999999999">
                                <input class="btn btn-default" type="submit" name="add"
                                       value="&#160;&#160;Add&#160;&#160;&#160;">
                            </div>
                        </form>
                    </div>
                @endif
            </div>
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h4><span class="glyphicon glyphicon-phone-alt"></span></h4>
                </div>
                <table class="table">
                    <tr class="active">
                        <th class="col-3">First Name</th>
                        <th class="col-3">Last Name</th>
                        <th class="col-4">Phone</th>
                        <th class="col-2">Edit</th>
                    </tr>
                    @foreach ($contacts as $contact)
                        <tr>
                            <td class="col-3">{{ $contact->first_name }}</td>
                            <td class="col-3">{{ $contact->last_name }}</td>
                            <td class="col-4">{{ $contact->phone_number }}</td>
                            <td class="col-2">
                                <a class="btn btn-default btn-block btn-xs" role="button"
                                   href='{{ route('contacts.edit', ['id' => $contact->id]) }}'>Edit</a>
                                <form action="{{ route('contacts.destroy', ['id' => $contact->id]) }}"
                                      method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <input class="btn btn-default btn-block btn-xs" type="submit" name="delete"
                                           value="Delete">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection