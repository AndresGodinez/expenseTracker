import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../wayfinder'
/**
* @see \App\Http\Controllers\CategoryIncomeController::index
* @see app/Http/Controllers/CategoryIncomeController.php:12
* @route '/category-incomes'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/category-incomes',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\CategoryIncomeController::index
* @see app/Http/Controllers/CategoryIncomeController.php:12
* @route '/category-incomes'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\CategoryIncomeController::index
* @see app/Http/Controllers/CategoryIncomeController.php:12
* @route '/category-incomes'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CategoryIncomeController::index
* @see app/Http/Controllers/CategoryIncomeController.php:12
* @route '/category-incomes'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\CategoryIncomeController::index
* @see app/Http/Controllers/CategoryIncomeController.php:12
* @route '/category-incomes'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CategoryIncomeController::index
* @see app/Http/Controllers/CategoryIncomeController.php:12
* @route '/category-incomes'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CategoryIncomeController::index
* @see app/Http/Controllers/CategoryIncomeController.php:12
* @route '/category-incomes'
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
* @see \App\Http\Controllers\CategoryIncomeController::create
* @see app/Http/Controllers/CategoryIncomeController.php:30
* @route '/category-incomes/create'
*/
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/category-incomes/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\CategoryIncomeController::create
* @see app/Http/Controllers/CategoryIncomeController.php:30
* @route '/category-incomes/create'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\CategoryIncomeController::create
* @see app/Http/Controllers/CategoryIncomeController.php:30
* @route '/category-incomes/create'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CategoryIncomeController::create
* @see app/Http/Controllers/CategoryIncomeController.php:30
* @route '/category-incomes/create'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\CategoryIncomeController::create
* @see app/Http/Controllers/CategoryIncomeController.php:30
* @route '/category-incomes/create'
*/
const createForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CategoryIncomeController::create
* @see app/Http/Controllers/CategoryIncomeController.php:30
* @route '/category-incomes/create'
*/
createForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CategoryIncomeController::create
* @see app/Http/Controllers/CategoryIncomeController.php:30
* @route '/category-incomes/create'
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
* @see \App\Http\Controllers\CategoryIncomeController::store
* @see app/Http/Controllers/CategoryIncomeController.php:38
* @route '/category-incomes'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/category-incomes',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\CategoryIncomeController::store
* @see app/Http/Controllers/CategoryIncomeController.php:38
* @route '/category-incomes'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\CategoryIncomeController::store
* @see app/Http/Controllers/CategoryIncomeController.php:38
* @route '/category-incomes'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\CategoryIncomeController::store
* @see app/Http/Controllers/CategoryIncomeController.php:38
* @route '/category-incomes'
*/
const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\CategoryIncomeController::store
* @see app/Http/Controllers/CategoryIncomeController.php:38
* @route '/category-incomes'
*/
storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

store.form = storeForm

/**
* @see \App\Http\Controllers\CategoryIncomeController::edit
* @see app/Http/Controllers/CategoryIncomeController.php:45
* @route '/category-incomes/{category_income}/edit'
*/
export const edit = (args: { category_income: number | { id: number } } | [category_income: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/category-incomes/{category_income}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\CategoryIncomeController::edit
* @see app/Http/Controllers/CategoryIncomeController.php:45
* @route '/category-incomes/{category_income}/edit'
*/
edit.url = (args: { category_income: number | { id: number } } | [category_income: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { category_income: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { category_income: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            category_income: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        category_income: typeof args.category_income === 'object'
        ? args.category_income.id
        : args.category_income,
    }

    return edit.definition.url
            .replace('{category_income}', parsedArgs.category_income.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\CategoryIncomeController::edit
* @see app/Http/Controllers/CategoryIncomeController.php:45
* @route '/category-incomes/{category_income}/edit'
*/
edit.get = (args: { category_income: number | { id: number } } | [category_income: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CategoryIncomeController::edit
* @see app/Http/Controllers/CategoryIncomeController.php:45
* @route '/category-incomes/{category_income}/edit'
*/
edit.head = (args: { category_income: number | { id: number } } | [category_income: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\CategoryIncomeController::edit
* @see app/Http/Controllers/CategoryIncomeController.php:45
* @route '/category-incomes/{category_income}/edit'
*/
const editForm = (args: { category_income: number | { id: number } } | [category_income: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CategoryIncomeController::edit
* @see app/Http/Controllers/CategoryIncomeController.php:45
* @route '/category-incomes/{category_income}/edit'
*/
editForm.get = (args: { category_income: number | { id: number } } | [category_income: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CategoryIncomeController::edit
* @see app/Http/Controllers/CategoryIncomeController.php:45
* @route '/category-incomes/{category_income}/edit'
*/
editForm.head = (args: { category_income: number | { id: number } } | [category_income: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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
* @see \App\Http\Controllers\CategoryIncomeController::update
* @see app/Http/Controllers/CategoryIncomeController.php:57
* @route '/category-incomes/{category_income}'
*/
export const update = (args: { category_income: number | { id: number } } | [category_income: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/category-incomes/{category_income}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\CategoryIncomeController::update
* @see app/Http/Controllers/CategoryIncomeController.php:57
* @route '/category-incomes/{category_income}'
*/
update.url = (args: { category_income: number | { id: number } } | [category_income: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { category_income: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { category_income: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            category_income: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        category_income: typeof args.category_income === 'object'
        ? args.category_income.id
        : args.category_income,
    }

    return update.definition.url
            .replace('{category_income}', parsedArgs.category_income.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\CategoryIncomeController::update
* @see app/Http/Controllers/CategoryIncomeController.php:57
* @route '/category-incomes/{category_income}'
*/
update.put = (args: { category_income: number | { id: number } } | [category_income: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\CategoryIncomeController::update
* @see app/Http/Controllers/CategoryIncomeController.php:57
* @route '/category-incomes/{category_income}'
*/
const updateForm = (args: { category_income: number | { id: number } } | [category_income: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\CategoryIncomeController::update
* @see app/Http/Controllers/CategoryIncomeController.php:57
* @route '/category-incomes/{category_income}'
*/
updateForm.put = (args: { category_income: number | { id: number } } | [category_income: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
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
* @see \App\Http\Controllers\CategoryIncomeController::destroy
* @see app/Http/Controllers/CategoryIncomeController.php:64
* @route '/category-incomes/{category_income}'
*/
export const destroy = (args: { category_income: number | { id: number } } | [category_income: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/category-incomes/{category_income}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\CategoryIncomeController::destroy
* @see app/Http/Controllers/CategoryIncomeController.php:64
* @route '/category-incomes/{category_income}'
*/
destroy.url = (args: { category_income: number | { id: number } } | [category_income: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { category_income: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { category_income: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            category_income: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        category_income: typeof args.category_income === 'object'
        ? args.category_income.id
        : args.category_income,
    }

    return destroy.definition.url
            .replace('{category_income}', parsedArgs.category_income.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\CategoryIncomeController::destroy
* @see app/Http/Controllers/CategoryIncomeController.php:64
* @route '/category-incomes/{category_income}'
*/
destroy.delete = (args: { category_income: number | { id: number } } | [category_income: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\CategoryIncomeController::destroy
* @see app/Http/Controllers/CategoryIncomeController.php:64
* @route '/category-incomes/{category_income}'
*/
const destroyForm = (args: { category_income: number | { id: number } } | [category_income: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\CategoryIncomeController::destroy
* @see app/Http/Controllers/CategoryIncomeController.php:64
* @route '/category-incomes/{category_income}'
*/
destroyForm.delete = (args: { category_income: number | { id: number } } | [category_income: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

destroy.form = destroyForm

const categoryIncomes = {
    index: Object.assign(index, index),
    create: Object.assign(create, create),
    store: Object.assign(store, store),
    edit: Object.assign(edit, edit),
    update: Object.assign(update, update),
    destroy: Object.assign(destroy, destroy),
}

export default categoryIncomes