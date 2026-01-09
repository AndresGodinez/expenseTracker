import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\ExpenseController::index
* @see app/Http/Controllers/ExpenseController.php:15
* @route '/expenses'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/expenses',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\ExpenseController::index
* @see app/Http/Controllers/ExpenseController.php:15
* @route '/expenses'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\ExpenseController::index
* @see app/Http/Controllers/ExpenseController.php:15
* @route '/expenses'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ExpenseController::index
* @see app/Http/Controllers/ExpenseController.php:15
* @route '/expenses'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\ExpenseController::index
* @see app/Http/Controllers/ExpenseController.php:15
* @route '/expenses'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ExpenseController::index
* @see app/Http/Controllers/ExpenseController.php:15
* @route '/expenses'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ExpenseController::index
* @see app/Http/Controllers/ExpenseController.php:15
* @route '/expenses'
*/
indexForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

index.form = indexForm

/**
* @see \App\Http\Controllers\ExpenseController::create
* @see app/Http/Controllers/ExpenseController.php:62
* @route '/expenses/create'
*/
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/expenses/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\ExpenseController::create
* @see app/Http/Controllers/ExpenseController.php:62
* @route '/expenses/create'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\ExpenseController::create
* @see app/Http/Controllers/ExpenseController.php:62
* @route '/expenses/create'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ExpenseController::create
* @see app/Http/Controllers/ExpenseController.php:62
* @route '/expenses/create'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\ExpenseController::create
* @see app/Http/Controllers/ExpenseController.php:62
* @route '/expenses/create'
*/
const createForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ExpenseController::create
* @see app/Http/Controllers/ExpenseController.php:62
* @route '/expenses/create'
*/
createForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ExpenseController::create
* @see app/Http/Controllers/ExpenseController.php:62
* @route '/expenses/create'
*/
createForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

create.form = createForm

/**
* @see \App\Http\Controllers\ExpenseController::store
* @see app/Http/Controllers/ExpenseController.php:75
* @route '/expenses'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/expenses',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\ExpenseController::store
* @see app/Http/Controllers/ExpenseController.php:75
* @route '/expenses'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\ExpenseController::store
* @see app/Http/Controllers/ExpenseController.php:75
* @route '/expenses'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\ExpenseController::store
* @see app/Http/Controllers/ExpenseController.php:75
* @route '/expenses'
*/
const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\ExpenseController::store
* @see app/Http/Controllers/ExpenseController.php:75
* @route '/expenses'
*/
storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

store.form = storeForm

/**
* @see \App\Http\Controllers\ExpenseController::edit
* @see app/Http/Controllers/ExpenseController.php:88
* @route '/expenses/{expense}/edit'
*/
export const edit = (args: { expense: number | { id: number } } | [expense: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/expenses/{expense}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\ExpenseController::edit
* @see app/Http/Controllers/ExpenseController.php:88
* @route '/expenses/{expense}/edit'
*/
edit.url = (args: { expense: number | { id: number } } | [expense: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { expense: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { expense: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            expense: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        expense: typeof args.expense === 'object'
        ? args.expense.id
        : args.expense,
    }

    return edit.definition.url
            .replace('{expense}', parsedArgs.expense.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\ExpenseController::edit
* @see app/Http/Controllers/ExpenseController.php:88
* @route '/expenses/{expense}/edit'
*/
edit.get = (args: { expense: number | { id: number } } | [expense: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ExpenseController::edit
* @see app/Http/Controllers/ExpenseController.php:88
* @route '/expenses/{expense}/edit'
*/
edit.head = (args: { expense: number | { id: number } } | [expense: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\ExpenseController::edit
* @see app/Http/Controllers/ExpenseController.php:88
* @route '/expenses/{expense}/edit'
*/
const editForm = (args: { expense: number | { id: number } } | [expense: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ExpenseController::edit
* @see app/Http/Controllers/ExpenseController.php:88
* @route '/expenses/{expense}/edit'
*/
editForm.get = (args: { expense: number | { id: number } } | [expense: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ExpenseController::edit
* @see app/Http/Controllers/ExpenseController.php:88
* @route '/expenses/{expense}/edit'
*/
editForm.head = (args: { expense: number | { id: number } } | [expense: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

edit.form = editForm

/**
* @see \App\Http\Controllers\ExpenseController::update
* @see app/Http/Controllers/ExpenseController.php:111
* @route '/expenses/{expense}'
*/
export const update = (args: { expense: number | { id: number } } | [expense: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/expenses/{expense}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\ExpenseController::update
* @see app/Http/Controllers/ExpenseController.php:111
* @route '/expenses/{expense}'
*/
update.url = (args: { expense: number | { id: number } } | [expense: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { expense: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { expense: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            expense: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        expense: typeof args.expense === 'object'
        ? args.expense.id
        : args.expense,
    }

    return update.definition.url
            .replace('{expense}', parsedArgs.expense.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\ExpenseController::update
* @see app/Http/Controllers/ExpenseController.php:111
* @route '/expenses/{expense}'
*/
update.put = (args: { expense: number | { id: number } } | [expense: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\ExpenseController::update
* @see app/Http/Controllers/ExpenseController.php:111
* @route '/expenses/{expense}'
*/
const updateForm = (args: { expense: number | { id: number } } | [expense: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\ExpenseController::update
* @see app/Http/Controllers/ExpenseController.php:111
* @route '/expenses/{expense}'
*/
updateForm.put = (args: { expense: number | { id: number } } | [expense: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

update.form = updateForm

/**
* @see \App\Http\Controllers\ExpenseController::destroy
* @see app/Http/Controllers/ExpenseController.php:126
* @route '/expenses/{expense}'
*/
export const destroy = (args: { expense: number | { id: number } } | [expense: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/expenses/{expense}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\ExpenseController::destroy
* @see app/Http/Controllers/ExpenseController.php:126
* @route '/expenses/{expense}'
*/
destroy.url = (args: { expense: number | { id: number } } | [expense: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { expense: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { expense: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            expense: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        expense: typeof args.expense === 'object'
        ? args.expense.id
        : args.expense,
    }

    return destroy.definition.url
            .replace('{expense}', parsedArgs.expense.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\ExpenseController::destroy
* @see app/Http/Controllers/ExpenseController.php:126
* @route '/expenses/{expense}'
*/
destroy.delete = (args: { expense: number | { id: number } } | [expense: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\ExpenseController::destroy
* @see app/Http/Controllers/ExpenseController.php:126
* @route '/expenses/{expense}'
*/
const destroyForm = (args: { expense: number | { id: number } } | [expense: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\ExpenseController::destroy
* @see app/Http/Controllers/ExpenseController.php:126
* @route '/expenses/{expense}'
*/
destroyForm.delete = (args: { expense: number | { id: number } } | [expense: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

destroy.form = destroyForm

const ExpenseController = { index, create, store, edit, update, destroy }

export default ExpenseController