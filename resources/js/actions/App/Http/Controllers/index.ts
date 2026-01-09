import DashboardController from './DashboardController'
import CategoryController from './CategoryController'
import PaymentMethodController from './PaymentMethodController'
import ExpenseController from './ExpenseController'
import CategoryIncomeController from './CategoryIncomeController'
import AccountController from './AccountController'
import IncomeController from './IncomeController'
import MonthlyReportsController from './MonthlyReportsController'
import Settings from './Settings'

const Controllers = {
    DashboardController: Object.assign(DashboardController, DashboardController),
    CategoryController: Object.assign(CategoryController, CategoryController),
    PaymentMethodController: Object.assign(PaymentMethodController, PaymentMethodController),
    ExpenseController: Object.assign(ExpenseController, ExpenseController),
    CategoryIncomeController: Object.assign(CategoryIncomeController, CategoryIncomeController),
    AccountController: Object.assign(AccountController, AccountController),
    IncomeController: Object.assign(IncomeController, IncomeController),
    MonthlyReportsController: Object.assign(MonthlyReportsController, MonthlyReportsController),
    Settings: Object.assign(Settings, Settings),
}

export default Controllers