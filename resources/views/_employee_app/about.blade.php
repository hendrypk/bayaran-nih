@extends('_employee_app._layout_employee.main')
@section('header.title', 'About Gajiplus')
@include('_employee_app._layout_employee.header')
@section('content')
<div class="presence">
    <div class="section full mt-2">
        <div class="wide-block pt-2 pb-2">
              
              <div id="releaseList">
                <!-- All release versions will be displayed here -->
              </div>
              
              <div id="latestRelease">
                <!-- Latest release version will be displayed here -->
              </div>

{{--                 
            <h4>About</h4>
            <div class="row">
                <div class="col">
                    <strong>
                        Designed & Developed by :
                    </strong>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <a href="https://www.cv.hendrypk.my.id" class="">Hendry PK</a>
                </div>
            </div>
            <h4>Change Log</h4>
            <p>All notable changes will be documented in this page</p>
            <div class="row mb-1">
                <div class="col">[1.0.0] - 4 October 2024</div>
            </div>
            <div class="row">
                <div class="col">[1.0.1] - 9 October 2024</div>
            </div>
            <div class="row">
                <div class="col">- Fix bug on add manual presence, edit presence, delete presence</div>
            </div>
            <div class="row">
                <div class="col">- Fix bug on presence summary</div>
            </div>
            <div class="row">
                <div class="col">[1.1.0] - 9 October 2024</div>
            </div>
            <div class="row">
                <div class="col">- Theme color changed</div>
            </div>
            <div class="row">
                <div class="col">- Fix bug on employee presence (office radius validation, save photo)</div>
            </div> --}}
        </div>
    </div>
</div>
@section('script')

@endsection
@endsection