<?php

Route::prefix('epanel/pengguna')->as('epanel.')->middleware(['auth', 'check.permission:Pengguna'])->group(function() 
{
    Route::resources([
        'roles' => 'RoleController',
        'operator' => 'OperatorController',
        
        'sso' => 'SSOController'
    ]);
});