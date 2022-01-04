@startuml
User -> Controller: [POST] /wagers
Controller -> Repository: createWager()
Repository -> Model : create()
Model --> Repository : Wager{}
Repository--> Controller : Wager{}
Controller --> User: [JSON] Wager detail
@enduml

@startuml
User -> Controller: [POST] /buy/{id}
Controller -> Repository: buyWager()
Repository -> Model : update()
Model --> Repository : Purchase{}
Repository--> Controller : Purchase{}
Controller --> User: [JSON] Purchase detail
@enduml

@startuml
User -> Controller: [GET] /wagers
Controller -> Repository: getListOfWager()
Repository -> Model : query()
Model --> Repository : Wager[]
Repository--> Controller : Wager[]
Controller --> User: [JSON] list of Wager detail
@enduml