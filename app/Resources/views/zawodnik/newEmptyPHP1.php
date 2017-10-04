{% extends 'base.html.twig' %}

{% block body %}
    <h1>Dodaj rezultat</h1>
    
    <div class="col-md-6" style="float:left">
        
        <form>
        <input type="integer" id="zawodnikNr" onchange="sendNrLic() "placeholder="Nr Licencji"/>
        <input type="button" value="Ok" onchange="sendNrLic()">
      </form>

      <form enctype="multipart/form-data" action="{{path('findUser')}}" method="post">
        <input type="text" id="find" name="find" placeholder="Wyszukaj osobę" />
       <button type="submit">Szukaj</button>
      </form>


 <p>
      
    {% if (res is defined and res) %}
       <table class="table"> <th>Imie</th> <th>Nazwisko</th> <th>Nr licencji</th> <th>Rok urodzenia</th> <th>Klub</th>
           {% for result in res %}
       <tr>
           <td>{{ result['imie'] }}</td> 
           <td>{{ result['nazwisko'] }}</td> 
           <td>{{ result['nrLic'] }}</td> 
           <td>{{ result['rokU'] }}</td> 
           <td>{{ result['klub'] }}</td> 
           
         <td>
                    <form enctype="multipart/form-data" action="{{path('findUserById')}}" method="post">
                          <input type="hidden" id="findById" name="findById" value="{{ result['id'] }}"/>
                        <button type="submit">X</button></form>
        </td>
           
       </tr><br/>
       {% endfor %}</table>
       
       <select class="form-control"  form="testform" id="testowe" name="testowe" data-width="100%">
        {% for result in res %}
            <option name="selectName{{ result['id'] }}" id="selectId{{ result['id'] }}" value="{{ result['id'] }}">{{ result['imie'] }}</option>
        {% endfor %}
       </select>
       
    {% endif%}
        
    {% if (resById is defined and resById) %}
      <table class="table"> <th>Imie</th> <th>Nazwisko</th> <th>Nr licencji</th> <th>Rok urodzenia</th> <th>Klub</th>
        <tr>
          <td>{{resById.imie}}</td>
          <td>{{resById.nazwisko}}</td>
          <td>{{resById.nrLic}}</td>
          <td>{{resById.rokU}}</td>
          <td>{{resById.klub}}</td>
        </tr>
      </table>
           <input type="text" id="appbundle_rezultaty[imie]" name="appbundle_rezultaty[imie]" value="{{resById.imie}}"/>
           <input type="hidden" id="nazwisko" name="nazwisko" value="{{resById.nazwisko}}"/>
           <input type="hidden" id="nrLic" name="nrLic" value="{{resById.nrLic}}"/>
           <input type="hidden" id="rokU" name="rokU" value="{{resById.rokU}}"/>
           <input type="hidden" id="klub" name="klub" value="{{resById.klub}}"/>
      {% endif%}
 </p>
        
    </div>

   
    <div class="col-md-6" style="float:left">
      
        
   {{ form_start(form) }}
    
         <div>
             {{ form_widget(form) }}
         </div>
        
         <input type="submit" value="Dodaj" />
        {{ form_end(form) }}
        
        
        
        
    </div>
    
    
    <script>
function sendNrLic() {
    alert("gdgbfsz");
}
</script>

{% endblock %}
