from django.urls import path
from . import views

urlpatterns = [
    path('', views.index, name='index'),
    path('donation', views.donation, name='donation'),
    path('orders', views.orders, name='orders'),
    path('ordering/<str:restaurant_id>', views.ordering, name='ordering'),
    path('login', views.login_view, name='login_view'),
    path('register', views.register_view, name='register_view'),
    path('confirm_order', views.confirm_order, name='confirm_order'),
    path('confirm_order_view', views.confirm_order_view, name='confirm_order_view'),
    path('logout', views.logout_view, name="logout_view"),
    path('write_review', views.write_review, name="write_review"),
    path('ordering/remove/<str:product_id>', views.remove_item_from_cart, name="remove_cart"),
    path('ordering/add/<str:restaurant_id>/<str:product_id>', views.add_item_to_cart, name="add_cart"),
    path('ordering/update/<str:product_id>/<int:qty>', views.update_cart_quantity, name="update_cart"),
    path('ordering/del/<str:restaurant_id>/<str:review_id>', views.delete_review, name="delete_review"),
    path('reorder/<str:order_id>', views.reorder, name="reorder")
]
