<?php
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// La landing de invitado es lo primero que se ve (RF-INV-01)
Route::get('/', [HomeController::class, 'index'])->name('welcome');
Route::get('/explorar', [HomeController::class, 'explorar'])->name('explorar');

// Rutas de autenticación (Solo para invitados)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Área privada (Solo registrados)
Route::middleware('auth')->group(function () {
    Route::redirect('/dashboard', '/')->name('dashboard');

    // Perfil público de cualquier usuario
    Route::get('/usuario/{id}', [\App\Http\Controllers\UserController::class, 'show'])->name('usuario.perfil');

    Route::middleware('user_only')->group(function () {
        Route::get('/intercambio/{id_camiseta}', [\App\Http\Controllers\TruequeController::class, 'create'])->name('intercambio.create');
        Route::post('/intercambio', [\App\Http\Controllers\TruequeController::class, 'store'])->name('intercambio.store');

        // Buzon y Chats
        Route::get('/buzon', [\App\Http\Controllers\ChatController::class, 'index'])->name('buzon.index');
        Route::get('/buzon/{chat}', [\App\Http\Controllers\ChatController::class, 'show'])->name('buzon.show');
        Route::post('/buzon/{chat}/mensaje', [\App\Http\Controllers\ChatController::class, 'sendMessage'])->name('buzon.message');
        Route::delete('/buzon/{chat}', [\App\Http\Controllers\ChatController::class, 'destroy'])->name('buzon.destroy');
        
        // Trueques (acciones dentro del chat)
        Route::post('/trueques/{trueque}/aceptar', [\App\Http\Controllers\ChatController::class, 'acceptProposal'])->name('trueques.accept');
        Route::post('/trueques/{trueque}/rechazar', [\App\Http\Controllers\ChatController::class, 'rejectProposal'])->name('trueques.reject');

        Route::get('/armario', function () {
            $camisetas = App\Models\Camiseta::where('user_id', auth()->id())->with('images')->latest()->get();
            return view('armario.index', compact('camisetas'));
        })->name('armario');

        Route::get('/camisetas/create', [App\Http\Controllers\CamisetaController::class, 'create'])->name('camisetas.create');
        Route::post('/camisetas', [App\Http\Controllers\CamisetaController::class, 'store'])->name('camisetas.store');
    });
    Route::get('/camisetas/{camiseta}/edit', [App\Http\Controllers\CamisetaController::class, 'edit'])->name('camisetas.edit');
    Route::put('/camisetas/{camiseta}', [App\Http\Controllers\CamisetaController::class, 'update'])->name('camisetas.update');
    Route::get('/camisetas/{camiseta}', [App\Http\Controllers\CamisetaController::class, 'show'])->name('camisetas.show');
    Route::patch('/camisetas/{camiseta}/toggle', [App\Http\Controllers\CamisetaController::class, 'toggle'])->name('camisetas.toggle');
    Route::delete('/camisetas/{camiseta}', [App\Http\Controllers\CamisetaController::class, 'destroy'])->name('camisetas.destroy');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Rutas del panel VAR (Administrador)
    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('/', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::patch('/camisetas/{id}/aprobar', [\App\Http\Controllers\AdminController::class, 'aprobarCamiseta'])->name('admin.aprobar');
        Route::patch('/camisetas/{id}/rechazar', [\App\Http\Controllers\AdminController::class, 'rechazarCamiseta'])->name('admin.rechazar');
        Route::patch('/usuarios/{id}/aprobar', [\App\Http\Controllers\AdminController::class, 'aprobarUsuario'])->name('admin.aprobarUsuario');
        Route::patch('/usuarios/{id}/rechazar', [\App\Http\Controllers\AdminController::class, 'rechazarUsuario'])->name('admin.rechazarUsuario');
        Route::get('/usuarios/{id}/edit', [\App\Http\Controllers\AdminController::class, 'editUser'])->name('admin.editUser');
        Route::put('/usuarios/{id}', [\App\Http\Controllers\AdminController::class, 'updateUser'])->name('admin.updateUser');
        Route::delete('/usuarios/{id}', [\App\Http\Controllers\AdminController::class, 'destroyUser'])->name('admin.destroyUser');
    });
});
