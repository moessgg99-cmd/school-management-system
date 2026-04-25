<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Home</title>
	<link rel="stylesheet" href="">
	<!-- {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}} -->
	<link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>

<body class="px-11">
	<div
		class="flex flex-col space-y-4 p-5 place-items-center bg-green-500 md:flex-row md:space-y-0 md:space-x-24 md:justify-center md:mt-5 md:p-3">

		<a href=""
			class="block px-4 border-2 border-transparent transition ease-out duration-500 text-white hover:bg-red-400 hover:rounded-md hover:border-white">
			Home
		</a>

		<a href=""
			class="block px-4 text-white border-2 border-transparent hover:bg-red-400 hover:rounded-md hover:border-white transition ease-out duration-500">
			Categories
		</a>

		<a href=""
			class="block px-4 text-white border-2 border-transparent hover:bg-red-400 hover:rounded-md hover:border-white transition ease-out duration-500">
			About
		</a>

		<a href=""
			class="block px-4 text-white border-2 border-transparent hover:bg-red-400 hover:rounded-md hover:border-white transition ease-out duration-500">
			Contact
		</a>

		<div class="flex flex-col space-y-2 md:flex-row md:space-y-0 md:space-x-2 md:absolute md:right-16">
			<a href="" class="text-center pl-2 pr-2 border-black border-2 rounded-md pb-1">Login</a>
			<a href="" class="text-center pl-2 pr-2 border-black border-2 rounded-md pb-1">Sign Up</a>
		</div>
	</div>
	<main>
		<div class="grid grid-cols-3">
			<div class="bg-blue-600">06</div>
			<div class="col-span-2 bg-blue-200">07</div>
		</div>
	</main>
</body>

</html>