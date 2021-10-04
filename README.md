# Module Sokoley Quiz

## Overview
Module made to suggest products by customers answers.
It allows:
* Make tests with any types of questions and variants of answers in admin panel
* Make GraphQL Query to get test by id with all questions and variants of answers, attached results with their "weights" for future processing in frontend
* Make GraphQL Query to get result title, result description and attached product list by result id

## Syntax

- GraphQl Endpoint
    - quizTest
```
query quizTest {
  quizTest(id: 5) {
    id
    name
    description
    questions {
      id
      title
      type
      variants {
        id
        title
        image
        result_weight {
          result_id
          weight
        }
      }
    }
  }
}
```
answer
```
{
  "data": {
    "quizTest": {
      "id": 5,
      "name": "Новый тест",
      "description": "<p>123</p>",
      "questions": [
        {
          "id": 11,
          "title": "Вопрос 11",
          "type": "chooserWithImg",
          "variants": [
            {
              "id": 45,
              "title": "12",
              "image": "",
              "result_weight": [
                {
                  "result_id": 9,
                  "weight": 300
                },
                {
                  "result_id": 10,
                  "weight": 300
                }
              ]
            }
          ]
        },
        {
          "id": 10,
          "title": "Вопрос 10",
          "type": "chooserWithoutImg",
          "variants": [
            {
              "id": 41,
              "title": "Вариант 1",
              "image": "760x760_7_.jpg",
              "result_weight": [
                {
                  "result_id": 8,
                  "weight": 200
                },
                {
                  "result_id": 9,
                  "weight": 200
                }
              ]
            },
            {
              "id": 42,
              "title": "Вариант 2",
              "image": "760x760_7_.jpg",
              "result_weight": [
                {
                  "result_id": 9,
                  "weight": 200
                },
                {
                  "result_id": 10,
                  "weight": 200
                }
              ]
            },
            {
              "id": 40,
              "title": "Вариант 3",
              "image": "",
              "result_weight": [
                {
                  "result_id": 7,
                  "weight": 200
                },
                {
                  "result_id": 8,
                  "weight": 200
                }
              ]
            }
          ]
        }
      ]
    }
  }
}
```


- GraphQl Endpoint
    - quizTestResult

```
query quizTestResult {
  quizTestResult(id: 8) {
    id
    title
    description
    products {
        sku
        url_key
    }
  }
}
```
answer
```
{
  "data": {
    "quizTestResult": {
      "id": 8,
      "title": "SS-1303 sku update rd reno",
      "description": "<p>lhuyguy</p>",
      "products": [
        {
          "sku": "E0309803",
          "url_key": "lp-mazhirel-5-1-50-ml"
        },
        {
          "sku": "E0315303",
          "url_key": "3474634003879"
        },
        {
          "sku": "E0315703",
          "url_key": "3474634003916"
        }
      ]
    }
  }
}
```


