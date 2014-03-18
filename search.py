#!/usr/bin/env python
#
# Rudimentary full text search endpoint in JSON - for use by our PHP application
#
import webapp2
import json
from google.appengine.api import search
from datetime import datetime

_INDEX_NAME = 'testindex'

# --------------------------------------------------------------------------------
# Example Request Handler
# --------------------------------------------------------------------------------
class TestHandler(webapp2.RequestHandler):
    def get(self):
        self.response.headers['Content-Type'] = 'application/json'
        obj = {
            'success': True,
            'message': 'Hello, world',
          }
        self.response.out.write(json.dumps(obj))

# --------------------------------------------------------------------------------
# Create Handler (Creates documents in the search index)
# --------------------------------------------------------------------------------
class CreateHandler(webapp2.RequestHandler):
    def post(self):

        # Grab parameters from POST
        title = self.request.get('title')
        contents = self.request.get('contents')
        created = float(self.request.get('created'))
        
        # Create the Document and populate the Index
        try:
          add_result = search.Index(name=_INDEX_NAME).put(self.createDocument(title, contents, created))
          obj = {
            'success': True
          }
        except search.Error:
          logging.exception('Indexing failed')
          obj = {
            'success': False
          }
        
        # Send the JSON response
        self.response.headers['Content-Type'] = 'application/json'
        self.response.out.write(json.dumps(obj))

    # SIMPLE Document factory
    def createDocument(self, title, contents, created):
        return search.Document(
            fields=[
                search.TextField(name='title', value=title),
                search.TextField(name='contents', value=contents),
                search.DateField(name='created', value=datetime.fromtimestamp(created))
            ]
        )

# --------------------------------------------------------------------------------
# Query Handler (runs search queries)
# --------------------------------------------------------------------------------
class QueryHandler(webapp2.RequestHandler):
    def post(self):
        query = self.request.get('q')
        query_obj = search.Query(
            query_string=query
        )
        results = search.Index(name=_INDEX_NAME).search(query=query_obj)

        # Compile results into desired JSON response format
        myresults = []
        for scored_document in results:
            obj_row = {
                'doc_id': scored_document.doc_id
            }
            for field in scored_document.fields:
                if field.name == 'title':
                    obj_row['title'] = field.value
                if field.name == 'contents':
                    obj_row['contents'] = field.value
                if field.name == 'created':
                    obj_row['created'] = field.value.isoformat()
            myresults.append(obj_row)

        obj = {
             'success': True,
             'count': len(results.results),
             'of': results.number_found,
             'results': myresults
        }
        self.response.headers['Content-Type'] = 'application/json'
        self.response.out.write(json.dumps(obj))

# --------------------------------------------------------------------------------
# Set up the application
# --------------------------------------------------------------------------------
app = webapp2.WSGIApplication([
    ('/', TestHandler),
    ('/create', CreateHandler),
    ('/query', QueryHandler),
], debug=True)
