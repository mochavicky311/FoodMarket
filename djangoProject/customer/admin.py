from django.contrib import admin
from django.contrib.auth.admin import UserAdmin
from .models import User, Restaurant, Product, Orderitem, Orderproduct, Review


admin.site.register(User, UserAdmin)
admin.site.register(Restaurant)
admin.site.register(Product)
admin.site.register(Orderitem)
admin.site.register(Orderproduct)
admin.site.register(Review)
