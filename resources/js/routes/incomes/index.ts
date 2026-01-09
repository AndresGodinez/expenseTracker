import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../wayfinder'
/**
* @see \App\Http\Controllers\IncomeController::index
* @see app/Http/Controllers/IncomeController.php:16
* @route '/incomes'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/incomes',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\IncomeController::index
* @see app/Http/Controllers/IncomeController.php:16
* @route '/incomes'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\IncomeController::index
* @see app/Http/Controllers/IncomeController.php:16
* @route '/incomes'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\IncomeController::index
* @see app/Http/Controllers/IncomeController.php:16
* @route '/incomes'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\IncomeController::index
* @see app/Http/Controllers/IncomeController.php:16
* @route '/incomes'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\IncomeController::index
* @see app/Http/Controllers/IncomeController.php:16
* @route '/incomes'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\IncomeController::index
* @see app/Http/Controllers/IncomeController.php:16
* @route '/incomes'
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
* @see \App\Http\Controllers\IncomeController::create
* @see app/Http/Controllers/IncomeController.php:61
* @route '/incomes/create'
*/
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/incomes/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\IncomeController::create
* @see app/Http/Controllers/IncomeController.php:61
* @route '/incomes/create'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\IncomeController::create
* @see app/Http/Controllers/IncomeController.php:61
* @route '/incomes/create'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\IncomeController::create
* @see app/Http/Controllers/IncomeController.php:61
* @route '/incomes/create'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\IncomeController::create
* @see app/Http/Controllers/IncomeController.php:61
* @route '/incomes/create'
*/
const createForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\IncomeController::create
* @see app/Http/Controllers/IncomeController.php:61
* @route '/incomes/create'
*/
createForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\IncomeController::create
* @see app/Http/Controllers/IncomeController.php:61
* @route '/incomes/create'
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
* @see \App\Http\Controllers\IncomeController::store
* @see app/Http/Controllers/IncomeController.php:74
* @route '/incomes'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/incomes',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\IncomeController::store
* @see app/Http/Controllers/IncomeController.php:74
* @route '/incomes'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\IncomeController::store
* @see app/Http/Controllers/IncomeController.php:74
* @route '/incomes'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\IncomeController::store
* @see app/Http/Controllers/IncomeController.php:74
* @route '/incomes'
*/
const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\IncomeController::store
* @see app/Http/Controllers/IncomeController.php:74
* @route '/incomes'
*/
storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

store.form = storeForm

/**
* @see \App\Http\Controllers\IncomeController::edit
* @see app/Http/Controllers/IncomeController.php:81
* @route '/incomes/{income}/edit'
*/
export const edit = (args: { income: number | { id: number } } | [income: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/incomes/{income}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\IncomeController::edit
* @see app/Http/Controllers/IncomeController.php:81
* @route '/incomes/{income}/edit'
*/
edit.url = (args: { income: number | { id: number } } | [income: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { income: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { income: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            income: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        income: typeof args.income === 'object'
        ? args.income.id
        : args.income,
    }

    return edit.definition.url
            .replace('{income}', parsedArgs.income.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\IncomeController::edit
* @see app/Http/Controllers/IncomeController.php:81
* @route '/incomes/{income}/edit'
*/
edit.get = (args: { income: number | { id: number } } | [income: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\IncomeController::edit
* @see app/Http/Controllers/IncomeController.php:81
* @route '/incomes/{income}/edit'
*/
edit.head = (args: { income: number | { id: number } } | [income: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\IncomeController::edit
* @see app/Http/Controllers/IncomeController.php:81
* @route '/incomes/{income}/edit'
*/
const editForm = (args: { income: number | { id: number } } | [income: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\IncomeController::edit
* @see app/Http/Controllers/IncomeController.php:81
* @route '/incomes/{income}/edit'
*/
editForm.get = (args: { income: number | { id: number } } | [income: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\IncomeController::edit
* @see app/Http/Controllers/IncomeController.php:81
* @route '/incomes/{income}/edit'
*/
editForm.head = (args: { income: number | { id: number } } | [income: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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
* @see \App\Http\Controllers\IncomeController::update
* @see app/Http/Controllers/IncomeController.php:103
* @route '/incomes/{income}'
*/
export const update = (args: { income: number | { id: number } } | [income: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/incomes/{income}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\IncomeController::update
* @see app/Http/Controllers/IncomeController.php:103
* @route '/incomes/{income}'
*/
update.url = (args: { income: number | { id: number } } | [income: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { income: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { income: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            income: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        income: typeof args.income === 'object'
        ? args.income.id
        : args.income,
    }

    return update.definition.url
            .replace('{income}', parsedArgs.income.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\IncomeController::update
* @see app/Http/Controllers/IncomeController.php:103
* @route '/incomes/{income}'
*/
update.put = (args: { income: number | { id: number } } | [income: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\IncomeController::update
* @see app/Http/Controllers/IncomeController.php:103
* @route '/incomes/{income}'
*/
const updateForm = (args: { income: number | { id: number } } | [income: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\IncomeController::update
* @see app/Http/Controllers/IncomeController.php:103
* @route '/incomes/{income}'
*/
updateForm.put = (args: { income: number | { id: number } } | [income: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
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
* @see \App\Http\Controllers\IncomeController::destroy
* @see app/Http/Controllers/IncomeController.php:117
* @route '/incomes/{income}'
*/
export const destroy = (args: { income: number | { id: number } } | [income: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/incomes/{income}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\IncomeController::destroy
* @see app/Http/Controllers/IncomeController.php:117
* @route '/incomes/{income}'
*/
destroy.url = (args: { income: number | { id: number } } | [income: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { income: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { income: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            income: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        income: typeof args.income === 'object'
        ? args.income.id
        : args.income,
    }

    return destroy.definition.url
            .replace('{income}', parsedArgs.income.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\IncomeController::destroy
* @see app/Http/Controllers/IncomeController.php:117
* @route '/incomes/{income}'
*/
destroy.delete = (args: { income: number | { id: number } } | [income: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\IncomeController::destroy
* @see app/Http/Controllers/IncomeController.php:117
* @route '/incomes/{income}'
*/
const destroyForm = (args: { income: number | { id: number } } | [income: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\IncomeController::destroy
* @see app/Http/Controllers/IncomeController.php:117
* @route '/incomes/{income}'
*/
destroyForm.delete = (args: { income: number | { id: number } } | [income: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

destroy.form = destroyForm

const incomes = {
    index: Object.assign(index, index),
    create: Object.assign(create, create),
    store: Object.assign(store, store),
    edit: Object.assign(edit, edit),
    update: Object.assign(update, update),
    destroy: Object.assign(destroy, destroy),
}

export default incomes