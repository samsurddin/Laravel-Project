<x-app-layout>
    <x-slot name="header">
        <div class="flex-item">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create New Invoice') }}
            </h2>
        </div>
        <div class="flex-item">
            {{-- <a class="btn-rounded" href="{{ route('users.create') }}"> Create New User</a>
            <a class="btn" href="{{ route('users.create') }}"> Create New Invoice</a> --}}
            <a class="btn-sm" href="{{ route('admin.roles.index', app()->getLocale()) }}"> All Invoices</a>
        </div>
    </x-slot>

    <div class="py-12 mx-4">
       
            <form action="">
            <div class="flex bg-white">
                <div class="w-[50%] mx-4 my-4 mb-0">
                    <div class="py-4">
                        <label for="" class="">Customer</label><br />
                        <select name="" class="w-[100%] my-[10px]" id="js-example-basic-single">
                            <option value="">
                                <span class="">Select and begin typing</span>
                            </option>
                        </select>
                    </div>

                    <div class="">
                        <label for="">Customer Account</label><br />
                        <select name="" class="w-[100%] mb-4" id="ih">
                            <option value="">Select</option>
                        </select>
                    </div>
                    <hr class="mt-5 mb-3" />
                    <span class="text-blue-600"><i class="fa-regular fa-pen-to-square"></i></span>
                    <div class="flex">
                        <div class="w-[50%]">
                            <h6>Bill To</h6>
                            <div>--</div>
                            <div>-- , --</div>
                            <span>-- , --</span>
                        </div>
                        <div>
                            <h6>Bill To</h6>
                            <div>--</div>
                            <div>-- , --</div>
                            <span>-- , --</span>
                        </div>
                    </div>


                    <div class="flex mt-4">
                        <div class="w-[20%] mr-7">
                            <label for="" class="">Prefix</label><br />
                            <select name="" class="w-[100%]" id="sec_all">
                                <option value="" class="py-[4px]">
                                    <span class="">All</span>
                                </option>
                            </select>
                        </div>
                        <div class="w-[65%] mr-4">
                            <label for="" class="">Prefixe</label><br />
                            <input type="text"
                                class="w-[100%] border border-gray-400 rounded-md py-[7px] outline-none" />
                        </div>
                        <div class="w-[20%] mr-0">
                            <label for="" class="">Prefix</label><br />
                            <select name="" class="w-[100%]" id="sec_all2">
                                <option value=""><span class="">All</span></option>
                            </select>
                        </div>
                    </div>



                    <div class="flex mt-4">
                        <div class="w-[45%] mr-5">
                            <label for="" class="">Customer</label><br />
                            <select name="" class="w-[100%] my-[10px]" id="ajax-example-basic-single">
                                <option value="">
                                    <span class="">Select and begin typing</span>
                                </option>
                            </select>
                        </div>
                        <div class="w-[50%] ml-6">
                            <label for="" class="">Customer</label><br />
                            <select name="" class="w-[100%] my-[10px]" id="select-example-basic-single">
                                <option value="">
                                    <span class="">Select and begin typing</span>
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class=" mt-4">
                        <label for="">Container No</label>
                        <select name="" class="w-[100%] " id="js-example-theme-multiple" multiple>
                            <option value="">
                                <span class="">Select and begin typing</span>
                            </option>
                        </select>
                    </div>

                    <div class=" mt-4">
                        <label for="">Container No</label>
                        <textarea name="" id="" class="w-[100%] border h-[80px] border-gray-400 rounded-md outline-none"
                            cols="0" rows="10"></textarea>
                    </div>

                    <div class="flex mt-4">
                        <div class="w-[30%] mr-7">
                            <label for="" class="">Prefix</label><br />
                            <input type="text"
                                class="w-[100%] border border-gray-400 rounded-md py-[7px] outline-none" />
                        </div>
                        <div class="w-[30%] mr-4">
                            <label for="" class="">Prefixe</label><br />
                            <input type="text"
                                class="w-[100%] border border-gray-400 rounded-md py-[7px] outline-none" />
                        </div>
                        <div class="w-[30%] mr-0">
                            <label for="" class="">Prefix</label><br />
                            <input type="date" class="w-[100%] border border-gray-400 rounded-md py-[7px] outline-none"
                                id="" name="">
                        </div>
                    </div>

                    <div class="flex">
                        <div class="w-[30%] mr-0">
                            <label for="" class="">Prefix</label><br />
                            <input type="date" class="w-[100%] border border-gray-400 rounded-md py-[7px] outline-none"
                                id="" name="">
                        </div>
                        <div class="w-[35%] ml-5">
                            <label for="" class="">Prefixe</label><br />
                            <select name="" class="w-[100%] outline-none" id="select_to" multiple>
                                <option value="">
                                    <span class="">Select and begin typing</span>
                                </option>
                            </select>
                        </div>


                    </div>
                    <div>
                        <label for="" class="">Prefixe</label><br />
                        <select name="" class="w-[60%] outline-none" id="select_tofinal" multiple>
                            <option value="">
                                <span class="">Select and begin typing</span>
                            </option>
                        </select>
                    </div>
                </div>

                <div class="mt-[27px] w-[50%]">
                    <div>
                        <p class="font-bold"><i class="fa-solid fa-tag mr-2"></i>Tags</p>
                        <select name="" class="border-none w-[95%]" id="tags">
                            <option value="">Tags</option>
                        </select>
                    </div>

                    <div class="mt-4">
                        <label for="">Payment method</label>
                        <select name="" class="border-none w-[95%]" id="Payment">
                            <option value="">Payment</option>
                        </select>
                    </div>

                    <div class="flex mt-4">
                        <div class="w-[45%] mr-5">
                            <label for="" class="">Prefix</label><br />
                            <input type="date" class="w-[100%] border border-gray-400 rounded-md py-[7px] outline-none"
                                id="" name="">
                        </div>
                        <div class="w-[45%] ml-5">
                            <label for="" class="">Prefix</label><br />
                            <input type="date" class="w-[100%] border border-gray-400 rounded-md py-[7px] outline-none"
                                id="" name="">
                        </div>
                    </div>
                    <div class="my-4">
                        <input type="checkbox" class="mr-3 w-4 h-4 items-center" name="" id=""><span class="pb-2">simply
                            dummy text of the printing and typesetting</span>
                    </div>

                    <div class="mt-4 flex">
                        <div class="w-[45%] mr-5">
                            <label for="" class="">Customer</label><br />
                            <select name="" class="w-[100%] my-[10px]" id="bdt">
                                <option value="">
                                    <span class="">Select and begin typing</span>
                                </option>
                            </select>
                        </div>
                        <div class="w-[45%] ml-6">
                            <label for="" class="">Customer</label><br />
                            <select name="" class="w-[100%] my-[10px]" id="inv">
                                <option value="">
                                    <span class="">Select and begin typing</span>
                                </option>
                            </select>
                        </div>
                    </div>


                    <div class="mt-4 flex">
                        <div class="w-[45%] mr-5">
                            <label for="" class="">Customer</label><br />
                            <input type="text"
                                class="w-[100%] border border-gray-400 rounded-md py-[7px] outline-none" />
                        </div>
                        <div class="w-[45%] ml-6">
                            <label for="" class="">Customer</label><br />
                            <input type="text"
                                class="w-[100%] border border-gray-400 rounded-md py-[7px] outline-none" />

                            </select>
                        </div>
                    </div>

                    <div class="mt-4 flex">
                        <div class="w-[45%] mr-5">
                            <label for="" class="">Customer</label><br />
                            <input type="text"
                                class="w-[100%] border border-gray-400 rounded-md py-[7px] outline-none" />
                        </div>
                        <div class="w-[45%] ml-6">
                            <label for="" class="">Customer</label><br />
                            <input type="text"
                                class="w-[100%] border border-gray-400 rounded-md py-[7px] outline-none" />

                            </select>
                        </div>
                    </div>
                    <div class="mt-4 flex">
                        <div class="w-[45%] mr-5">
                            <label for="" class="">Customer</label><br />
                            <input type="text"
                                class="w-[100%] border border-gray-400 rounded-md py-[7px] outline-none" />
                        </div>

                    </div>

                    <div class="mt-4">
                        <div class=" mt-4">
                            <label for="">Container No</label>
                            <textarea name="" id=""
                                class="w-[95%] border h-[80px] border-gray-400 rounded-md outline-none" cols="0"
                                rows="10"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 py-4 px-4 block bg-white">
                <div class=" w-[100%] flex mb-4">
                    <div class="w-[20%] flex">
                        <select name="" id="item" class="w-[100%]">
                            <option value="">Add Item</option>
                        </select>
                        <button class="bg-gray-200 w-10 h-10 font-bold rounded-r-md ml-2"><span>+</span></button>
                    </div>
                    <div class="w-[20%] flex">
                        <select class="w-[100%]  outline-none border border-gray-300 px-4 rounded-l-sm ml-4">
                            <option value="">Bill Tasks</option>
                        </select>
                        <button class="bg-gray-200 w-10 h-10 font-bold rounded-r-md "><span>?</span></button>
                    </div>
                    <div class="w-[60%] justify-end pl-[40%] pt-[5px] mt-1">
                        <span>Show Quntity as :</span>
                        <input type="radio" name="" id="" class="w-5 h-4 pr-3">
                        <input type="radio" name="" id="" class="w-5 h-4 pr-3">
                        <input type="radio" name="" id="" class="w-5 h-4 ">
                    </div>
                </div>
                <div class="block">

                    <div class="w-full block">
                        <table class="w-full bg-gray-200">
                            <thead class=" bg-black text-white py-[15px]">
                                <tr class="">
                                    <th class="py-[8px]">Home</th>
                                    <th>Home</th>
                                    <th>Home</th>
                                    <th>Home</th>
                                    <th>Home</th>
                                    <th>Home</th>
                                    <th>Home</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="w-[16%] p-4">
                                        <textarea name="" id="" cols="10" rows="5"
                                            class="w-[90%] h-24 mt-4 outline-none rounded-md"></textarea>
                                    </td>
                                    <td class="w-[20%]">
                                        <textarea name="" id="" cols="10" rows="5"
                                            class="w-[90%] h-24 mt-4 outline-none rounded-md"></textarea>
                                    </td>
                                    <td>
                                        <input type="checkbox" class="mr-3 w-4 h-4 items-center" name="" id="">
                                    </td>
                                    <td>
                                        <input type="number" class="outline-none py-3 px-4 rounded-md w-[40%]">
                                    </td>
                                    <td>
                                        <input type="text" class="outline-none py-3 px-4 rounded-md w-[80%]">
                                    </td>
                                    <td>
                                        <input type="text" class="outline-none py-3 px-4 rounded-md w-[80%]">
                                    </td>
                                    <td>
                                        <button class="bg-blue-500 text-white py-2 px-2 rounded-md"><i
                                                class="fa-solid fa-check"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="w-full">
                        <div class="ml-[40%] w-[60%] mt-4 border-t-2">
                            <div class="ml-[65%]">
                                <span class=""><b>Subtotal :</b></span>
                                <span class="ml-[60%]">৳<b>0.00</b> </span>
                            </div>
                            
                        </div>
                        <div class="ml-[40%] w-[60%] mt-4 border-t-2">
                            <div class="ml-[40%] mt-2">
                                <input type="text" class="border border-gray-300 py-2 w-[48%]">
                                <button class="bg-gray-200 w-10 h-[42px] font-bold rounded-r-md ml-[-5px]"><span>%</span></button>
                            </div>
                        </div>
                        <div class="ml-[40%] w-[60%] mt-4 border-t-2">
                            <div class="ml-[40%] mt-2">
                                <input type="text" class="border border-gray-300 py-2 w-[55%]">
                            </div>
                        </div>
                        <div class="ml-[40%] w-[60%] mt-4 border-t-2">
                            <div class="ml-[68%]">
                                <span class=""><b>total :</b></span>
                                <span class="ml-[67%]">৳<b>0.00</b> </span>
                            </div>
                        </div>
                    </div>

                </div>




            </div>
            <div class="mt-4 w-full bg-white p-4">
                <div class="mt-4">
                    <label for="">Client Note</label>
                    <textarea name="" id="" cols="10" rows="5"
                        class="w-full border border-gray-300 rounded-md h-24"></textarea>
                </div>

                <div>
                    <label for="">terms and conditions</label>
                    <textarea name="" id="" cols="10" rows="5"
                        class="w-full border border-gray-300 rounded-md h-24"></textarea>
                </div>
            </div>

            <div class="mt-4 mx-[-16px] bg-white">
                <div class="ml-[80%] py-[10px]">
                    <button
                        class=" bg-gray-200 border border-gray-300 py-[6px] px-[25] mx-4 rounded-md text-[14px]">SAVE AS
                        DRAFT</button>
                    <button
                        class="bg-blue-500 text-white px-[15px] border border-gray-300 py-[6px] rounded-md text-[16px]">SAVE</button>
                </div>
            </div>
        </form>



        </div>
    </div>
</x-app-layout>
