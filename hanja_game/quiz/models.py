from django.db import models

class Question(models.Model):
    hanja = models.CharField(max_length=10)  # 한자
    mean = models.CharField(max_length=30)  # 뜻
    sound = models.CharField(max_length=10)  # 음
    level = models.CharField(max_length=10)  # 급수

    def __str__(self):
        return self.hanja

