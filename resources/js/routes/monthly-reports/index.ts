import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../wayfinder'
/**
* @see \App\Http\Controllers\MonthlyReportsController::index
* @see app/Http/Controllers/MonthlyReportsController.php:13
* @route '/monthly-reports'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/monthly-reports',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\MonthlyReportsController::index
* @see app/Http/Controllers/MonthlyReportsController.php:13
* @route '/monthly-reports'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\MonthlyReportsController::index
* @see app/Http/Controllers/MonthlyReportsController.php:13
* @route '/monthly-reports'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\MonthlyReportsController::index
* @see app/Http/Controllers/MonthlyReportsController.php:13
* @route '/monthly-reports'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\MonthlyReportsController::index
* @see app/Http/Controllers/MonthlyReportsController.php:13
* @route '/monthly-reports'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\MonthlyReportsController::index
* @see app/Http/Controllers/MonthlyReportsController.php:13
* @route '/monthly-reports'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\MonthlyReportsController::index
* @see app/Http/Controllers/MonthlyReportsController.php:13
* @route '/monthly-reports'
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
* @see \App\Http\Controllers\MonthlyReportsController::show
* @see app/Http/Controllers/MonthlyReportsController.php:40
* @route '/monthly-reports/{monthlyReport}'
*/
export const show = (args: { monthlyReport: number | { id: number } } | [monthlyReport: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/monthly-reports/{monthlyReport}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\MonthlyReportsController::show
* @see app/Http/Controllers/MonthlyReportsController.php:40
* @route '/monthly-reports/{monthlyReport}'
*/
show.url = (args: { monthlyReport: number | { id: number } } | [monthlyReport: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { monthlyReport: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { monthlyReport: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            monthlyReport: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        monthlyReport: typeof args.monthlyReport === 'object'
        ? args.monthlyReport.id
        : args.monthlyReport,
    }

    return show.definition.url
            .replace('{monthlyReport}', parsedArgs.monthlyReport.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\MonthlyReportsController::show
* @see app/Http/Controllers/MonthlyReportsController.php:40
* @route '/monthly-reports/{monthlyReport}'
*/
show.get = (args: { monthlyReport: number | { id: number } } | [monthlyReport: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\MonthlyReportsController::show
* @see app/Http/Controllers/MonthlyReportsController.php:40
* @route '/monthly-reports/{monthlyReport}'
*/
show.head = (args: { monthlyReport: number | { id: number } } | [monthlyReport: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\MonthlyReportsController::show
* @see app/Http/Controllers/MonthlyReportsController.php:40
* @route '/monthly-reports/{monthlyReport}'
*/
const showForm = (args: { monthlyReport: number | { id: number } } | [monthlyReport: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\MonthlyReportsController::show
* @see app/Http/Controllers/MonthlyReportsController.php:40
* @route '/monthly-reports/{monthlyReport}'
*/
showForm.get = (args: { monthlyReport: number | { id: number } } | [monthlyReport: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\MonthlyReportsController::show
* @see app/Http/Controllers/MonthlyReportsController.php:40
* @route '/monthly-reports/{monthlyReport}'
*/
showForm.head = (args: { monthlyReport: number | { id: number } } | [monthlyReport: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

show.form = showForm

const monthlyReports = {
    index: Object.assign(index, index),
    show: Object.assign(show, show),
}

export default monthlyReports