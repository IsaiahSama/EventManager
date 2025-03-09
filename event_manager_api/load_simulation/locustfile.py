from locust import HttpUser, task

base_url = "http://127.0.0.1:8080/"

events_url = base_url + "events/"
auth_url = base_url + "auth/"
user_url = base_url + "user/"


class ScalableTester(HttpUser):
    @task
    def test_getting_all_events(self):
        self.client.get(events_url)
